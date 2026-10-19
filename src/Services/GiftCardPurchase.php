<?php

namespace Brainstream\Giftcard\Services;

use Brainstream\Giftcard\Contracts\GiftCard;
use Brainstream\Giftcard\Mail\GiftCardMail;
use Brainstream\Giftcard\Models\GiftCard as GiftCardModel;
use Brainstream\Giftcard\Repositories\GiftCardPaymentRepository;
use Brainstream\Giftcard\Repositories\GiftCardRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Webkul\Paypal\Payment\SmartButton;

class GiftCardPurchase
{
    /**
     * Session key holding purchases waiting for PayPal approval.
     */
    public const SESSION_KEY = 'gift_card_purchases';

    /**
     * Payment method code recorded for PayPal purchases.
     */
    public const PAYMENT_METHOD = 'paypal_smart_button';

    /**
     * Create a new service instance.
     */
    public function __construct(
        protected GiftCardRepository $giftCardRepository,
        protected GiftCardPaymentRepository $giftCardPaymentRepository,
        protected SmartButton $smartButton
    ) {}

    /**
     * Get the storefront purchase settings.
     */
    public function settings(): array
    {
        $presets = collect(explode(',', (string) $this->config('preset_amounts')))
            ->map(fn ($amount) => (float) trim($amount))
            ->filter(fn ($amount) => $amount > 0)
            ->values()
            ->all();

        return [
            'min_amount' => (float) ($this->config('min_amount') ?: 1),
            'max_amount' => (float) ($this->config('max_amount') ?: 500),
            'preset_amounts' => $presets,
            'validity_days' => (int) ($this->config('validity_days') ?: 365),
            'currency' => core()->getBaseCurrencyCode(),
            'client_id' => core()->getConfigData('sales.payment_methods.paypal_smart_button.client_id'),
        ];
    }

    /**
     * Determine whether gift cards can be bought on the storefront.
     */
    public function isAvailable(): bool
    {
        return (bool) $this->config('active')
            && (bool) core()->getConfigData('sales.payment_methods.paypal_smart_button.active')
            && filled(core()->getConfigData('sales.payment_methods.paypal_smart_button.client_id'));
    }

    /**
     * Determine whether PayPal accepts the base currency.
     */
    public function isCurrencySupported(): bool
    {
        $accepted = array_map(
            'trim',
            explode(',', (string) core()->getConfigData('sales.payment_methods.paypal_smart_button.accepted_currencies'))
        );

        return in_array(core()->getBaseCurrencyCode(), $accepted);
    }

    /**
     * Get the occasions with their image URLs.
     */
    public function occasions(): array
    {
        return collect(config('giftcard.occasions', []))
            ->map(fn ($image, $key) => [
                'key' => $key,
                'name' => trans('giftcard::app.shop.occasions.'.$key),
                'greeting' => trans('giftcard::app.shop.greetings.'.$key),
                'image' => $this->occasionImageUrl($key),
            ])
            ->values()
            ->all();
    }

    /**
     * Get the public URL of an occasion image.
     */
    public function occasionImageUrl(?string $occasion): ?string
    {
        $image = config('giftcard.occasions.'.$occasion);

        return $image ? asset('vendor/giftcard/images/'.$image) : null;
    }

    /**
     * Create a PayPal order for the purchase and remember it in the session.
     */
    public function createPaypalOrder(array $purchase): string
    {
        $amount = $this->formatAmount($purchase['amount']);

        $order = $this->smartButton->createOrder([
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'description' => trans('giftcard::app.shop.purchase.title'),
                    'amount' => [
                        'currency_code' => core()->getBaseCurrencyCode(),
                        'value' => $amount,
                    ],
                ],
            ],
            'application_context' => [
                'shipping_preference' => 'NO_SHIPPING',
            ],
        ]);

        session()->put(self::SESSION_KEY.'.'.$order->getId(), array_merge($purchase, [
            'amount' => $amount,
            'currency' => core()->getBaseCurrencyCode(),
        ]));

        return $order->getId();
    }

    /**
     * Get a purchase waiting for approval.
     */
    public function pendingPurchase(string $paypalOrderId): ?array
    {
        return session()->get(self::SESSION_KEY.'.'.$paypalOrderId);
    }

    /**
     * Capture an approved PayPal order and issue the gift card it paid for.
     */
    public function capture(string $paypalOrderId, array $purchase): ?GiftCard
    {
        $existingPayment = $this->giftCardPaymentRepository->findOneByField('order_id', $paypalOrderId);

        if ($existingPayment) {
            return $existingPayment->giftCard;
        }

        $order = $this->smartButton->captureOrder($paypalOrderId);

        $purchaseUnit = $order->getPurchaseUnits()[0] ?? null;

        $capture = $purchaseUnit?->getPayments()?->getCaptures()[0] ?? null;

        if (
            $order->getStatus() !== 'COMPLETED'
            || ! $capture
            || $capture->getStatus() !== 'COMPLETED'
            || $capture->getAmount()->getCurrencyCode() !== $purchase['currency']
            || abs((float) $capture->getAmount()->getValue() - (float) $purchase['amount']) > GiftCardManager::EPSILON
        ) {
            return null;
        }

        $giftCard = DB::transaction(function () use ($order, $capture, $purchase, $paypalOrderId) {
            $giftCard = $this->giftCardRepository->create([
                'giftcard_amount' => $purchase['amount'],
                'giftcard_status' => GiftCardModel::STATUS_ACTIVE,
                'expirationdate' => now()->addDays($this->settings()['validity_days'])->toDateString(),
                'sendername' => $purchase['sender_name'],
                'senderemail' => $purchase['sender_email'],
                'recipientname' => $purchase['recipient_name'],
                'recipientemail' => $purchase['recipient_email'],
                'message' => $purchase['message'] ?? null,
                'occasion' => $purchase['occasion'],
            ]);

            $this->giftCardPaymentRepository->create([
                'giftcard_number' => $giftCard->giftcard_number,
                'order_id' => $paypalOrderId,
                'payment_id' => $capture->getId(),
                'payer_id' => (string) $order->getPayer()?->getPayerId(),
                'payer_email' => (string) $order->getPayer()?->getEmailAddress(),
                'amount' => $purchase['amount'],
                'currency' => $purchase['currency'],
                'status' => strtolower($capture->getStatus()),
                'payment_data' => json_decode(json_encode($order), true),
                'payment_type' => self::PAYMENT_METHOD,
            ]);

            return $giftCard;
        });

        session()->forget(self::SESSION_KEY.'.'.$paypalOrderId);

        try {
            Mail::send(new GiftCardMail($giftCard));
        } catch (\Exception $e) {
            report($e);
        }

        return $giftCard;
    }

    /**
     * Format an amount the way PayPal expects it.
     */
    protected function formatAmount(float|string $amount): string
    {
        return number_format((float) $amount, 2, '.', '');
    }

    /**
     * Read a gift card setting for the current channel.
     */
    protected function config(string $field): mixed
    {
        return core()->getConfigData('sales.gift_card.settings.'.$field);
    }
}
