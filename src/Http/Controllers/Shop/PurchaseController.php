<?php

namespace Brainstream\Giftcard\Http\Controllers\Shop;

use Brainstream\Giftcard\Http\Requests\PurchaseRequest;
use Brainstream\Giftcard\Services\GiftCardPurchase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Webkul\Shop\Http\Controllers\Controller;

class PurchaseController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(protected GiftCardPurchase $giftCardPurchase) {}

    /**
     * Display the gift card purchase page.
     */
    public function index(): View
    {
        return view('giftcard::shop.gift-cards.index', [
            'isAvailable' => $this->giftCardPurchase->isAvailable(),
            'isCurrencySupported' => $this->giftCardPurchase->isCurrencySupported(),
            'settings' => $this->giftCardPurchase->settings(),
            'occasions' => $this->giftCardPurchase->occasions(),
        ]);
    }

    /**
     * Create the PayPal order for a gift card purchase.
     */
    public function createOrder(PurchaseRequest $request): JsonResponse
    {
        if (! $this->giftCardPurchase->isAvailable()) {
            return $this->errorResponse(trans('giftcard::app.shop.purchase.unavailable'));
        }

        if (! $this->giftCardPurchase->isCurrencySupported()) {
            return $this->errorResponse(trans('giftcard::app.shop.purchase.currency-unsupported', [
                'currency' => core()->getBaseCurrencyCode(),
            ]));
        }

        try {
            $paypalOrderId = $this->giftCardPurchase->createPaypalOrder($request->validated());
        } catch (\Exception $e) {
            report($e);

            return $this->errorResponse(trans('giftcard::app.shop.purchase.payment-failed'));
        }

        return new JsonResponse(['id' => $paypalOrderId]);
    }

    /**
     * Capture an approved PayPal order and issue the gift card.
     */
    public function captureOrder(): JsonResponse
    {
        $this->validate(request(), [
            'order_id' => ['required', 'string', 'max:64'],
        ]);

        $paypalOrderId = request()->input('order_id');

        $purchase = $this->giftCardPurchase->pendingPurchase($paypalOrderId);

        if (! $purchase) {
            return $this->errorResponse(trans('giftcard::app.shop.purchase.session-expired'));
        }

        try {
            $giftCard = $this->giftCardPurchase->capture($paypalOrderId, $purchase);
        } catch (\Exception $e) {
            report($e);

            $giftCard = null;
        }

        if (! $giftCard) {
            return $this->errorResponse(trans('giftcard::app.shop.purchase.payment-failed'));
        }

        session()->flash('gift_card_purchase', [
            'amount' => core()->formatBasePrice((float) $purchase['amount']),
            'email' => $giftCard->recipientemail,
        ]);

        return new JsonResponse([
            'redirect_url' => route('shop.gift_cards.success'),
        ]);
    }

    /**
     * Display the purchase confirmation.
     */
    public function success(): View|RedirectResponse
    {
        $purchase = session('gift_card_purchase');

        if (! $purchase) {
            return redirect()->route('shop.gift_cards.index');
        }

        return view('giftcard::shop.gift-cards.success', compact('purchase'));
    }

    /**
     * Build an error response for the purchase flow.
     */
    protected function errorResponse(string $message): JsonResponse
    {
        return new JsonResponse(['message' => $message], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
