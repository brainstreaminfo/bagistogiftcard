<?php

namespace Brainstream\Giftcard\Observers;

use Webkul\Sales\Contracts\Invoice;

class InvoiceObserver
{
    /**
     * Allocate the order's gift card amount to the invoice being totalled.
     */
    public function saving(Invoice $invoice): void
    {
        if (! $invoice->isDirty('grand_total')) {
            return;
        }

        $order = $invoice->order;

        if (
            ! $order
            || (float) $order->base_giftcard_amount <= 0
        ) {
            return;
        }

        $baseAllocated = (float) $order->invoices()
            ->where('id', '!=', (int) $invoice->id)
            ->sum('base_giftcard_amount');

        $baseAmount = round(max(0, min(
            (float) $order->base_giftcard_amount - $baseAllocated,
            (float) $invoice->base_grand_total
        )), 4);

        $amount = round($baseAmount * (float) $order->giftcard_amount / (float) $order->base_giftcard_amount, 4);

        $invoice->giftcard_number = $order->giftcard_number;
        $invoice->giftcard_amount = $amount;
        $invoice->base_giftcard_amount = $baseAmount;

        $invoice->grand_total = round((float) $invoice->grand_total - $amount, 4);
        $invoice->base_grand_total = round((float) $invoice->base_grand_total - $baseAmount, 4);
    }
}
