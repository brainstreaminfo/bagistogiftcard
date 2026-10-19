<?php

namespace Brainstream\Giftcard\Observers;

use Brainstream\Giftcard\Services\GiftCardManager;
use Webkul\Sales\Contracts\Refund;

class RefundObserver
{
    /**
     * Create a new observer instance.
     */
    public function __construct(protected GiftCardManager $giftCardManager) {}

    /**
     * Split the refund between the gift card and the original payment.
     */
    public function saving(Refund $refund): void
    {
        if (! $refund->isDirty('grand_total')) {
            return;
        }

        $order = $refund->order;

        if (
            ! $order
            || (float) $order->base_giftcard_amount <= 0
        ) {
            return;
        }

        $baseOrderTotal = (float) $order->base_grand_total + (float) $order->base_giftcard_amount;

        if ($baseOrderTotal <= 0) {
            return;
        }

        $baseRefundable = (float) $order->invoices()->sum('base_giftcard_amount')
            - (float) $order->refunds()->where('id', '!=', (int) $refund->id)->sum('base_giftcard_amount');

        $baseAmount = round(max(0, min(
            (float) $refund->base_grand_total * (float) $order->base_giftcard_amount / $baseOrderTotal,
            $baseRefundable
        )), 4);

        $amount = round($baseAmount * (float) $order->giftcard_amount / (float) $order->base_giftcard_amount, 4);

        $refund->giftcard_amount = $amount;
        $refund->base_giftcard_amount = $baseAmount;

        $refund->grand_total = round((float) $refund->grand_total - $amount, 4);
        $refund->base_grand_total = round((float) $refund->base_grand_total - $baseAmount, 4);
    }

    /**
     * Return the gift card share of the refund to the card.
     */
    public function saved(Refund $refund): void
    {
        $baseDelta = round((float) $refund->base_giftcard_amount - (float) $refund->getOriginal('base_giftcard_amount'), 4);

        if (
            $baseDelta > 0
            && $refund->order?->giftcard_number
        ) {
            $this->giftCardManager->credit($refund->order->giftcard_number, $baseDelta);
        }
    }
}
