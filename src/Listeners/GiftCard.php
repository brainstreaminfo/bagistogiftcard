<?php

namespace Brainstream\Giftcard\Listeners;

use Brainstream\Giftcard\Services\GiftCardManager;
use Webkul\Checkout\Contracts\Cart;
use Webkul\Sales\Contracts\Order;

class GiftCard
{
    /**
     * Create a new listener instance.
     */
    public function __construct(protected GiftCardManager $giftCardManager) {}

    /**
     * Take the applied gift card off the freshly collected cart totals.
     */
    public function applyToCart(Cart $cart): void
    {
        if (! $cart->giftcard_number) {
            return;
        }

        $giftCard = $this->giftCardManager->findRedeemable($cart->giftcard_number);

        if (! $giftCard) {
            $cart->giftcard_number = null;
            $cart->giftcard_amount = null;
            $cart->base_giftcard_amount = null;
            $cart->remaining_giftcard_amount = 0;

            $cart->save();

            return;
        }

        $baseGrandTotal = max(0, (float) $cart->base_grand_total);

        $grandTotal = max(0, (float) $cart->grand_total);

        $baseAmount = round(min($giftCard->giftcard_amount, $baseGrandTotal), 2);

        $amount = $baseAmount >= $baseGrandTotal
            ? $grandTotal
            : round(min(core()->convertPrice($baseAmount, $cart->cart_currency_code), $grandTotal), 2);

        $cart->base_giftcard_amount = $baseAmount;
        $cart->giftcard_amount = $amount;
        $cart->remaining_giftcard_amount = round($giftCard->giftcard_amount - $baseAmount, 4);

        $cart->base_grand_total = round($baseGrandTotal - $baseAmount, 2);
        $cart->grand_total = round($grandTotal - $amount, 2);

        $cart->save();
    }

    /**
     * Return the unused gift card amount of a canceled order to the card.
     */
    public function restoreFromCanceledOrder(Order $order): void
    {
        if (
            ! $order->giftcard_number
            || (float) $order->base_giftcard_amount <= 0
        ) {
            return;
        }

        $baseInvoiced = (float) $order->invoices()->sum('base_giftcard_amount');

        $baseRestorable = round(
            (float) $order->base_giftcard_amount - $baseInvoiced - (float) $order->base_giftcard_amount_canceled,
            4
        );

        if ($baseRestorable <= 0) {
            return;
        }

        $this->giftCardManager->credit($order->giftcard_number, $baseRestorable);

        $order->base_giftcard_amount_canceled = round((float) $order->base_giftcard_amount_canceled + $baseRestorable, 4);

        $order->save();
    }
}
