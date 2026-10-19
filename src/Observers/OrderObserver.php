<?php

namespace Brainstream\Giftcard\Observers;

use Brainstream\Giftcard\Services\GiftCardManager;
use Webkul\Checkout\Repositories\CartRepository;
use Webkul\Sales\Contracts\Order;

class OrderObserver
{
    /**
     * Create a new observer instance.
     */
    public function __construct(
        protected CartRepository $cartRepository,
        protected GiftCardManager $giftCardManager
    ) {}

    /**
     * Copy the gift card applied to the cart onto the order being placed.
     */
    public function creating(Order $order): void
    {
        if (
            ! $order->cart_id
            || $order->giftcard_number
        ) {
            return;
        }

        $cart = $this->cartRepository->find($order->cart_id);

        if (
            ! $cart?->giftcard_number
            || (float) $cart->base_giftcard_amount <= 0
        ) {
            return;
        }

        $order->giftcard_number = $cart->giftcard_number;
        $order->giftcard_amount = $cart->giftcard_amount;
        $order->base_giftcard_amount = $cart->base_giftcard_amount;
    }

    /**
     * Take the gift card amount off the card once the order exists.
     */
    public function created(Order $order): void
    {
        if (
            $order->giftcard_number
            && (float) $order->base_giftcard_amount > 0
        ) {
            $this->giftCardManager->debit($order->giftcard_number, (float) $order->base_giftcard_amount);
        }
    }

    /**
     * Keep the invoiced and refunded totals net of the gift card.
     */
    public function saving(Order $order): void
    {
        if (
            ! $order->exists
            || (float) $order->base_giftcard_amount <= 0
        ) {
            return;
        }

        if ($order->isDirty('grand_total_invoiced')) {
            $order->grand_total_invoiced = round((float) $order->grand_total_invoiced - (float) $order->invoices()->sum('giftcard_amount'), 4);
            $order->base_grand_total_invoiced = round((float) $order->base_grand_total_invoiced - (float) $order->invoices()->sum('base_giftcard_amount'), 4);
        }

        if ($order->isDirty('grand_total_refunded')) {
            $order->grand_total_refunded = round((float) $order->grand_total_refunded - (float) $order->refunds()->sum('giftcard_amount'), 4);
            $order->base_grand_total_refunded = round((float) $order->base_grand_total_refunded - (float) $order->refunds()->sum('base_giftcard_amount'), 4);
        }
    }
}
