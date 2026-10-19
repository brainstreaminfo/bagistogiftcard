<?php

namespace Brainstream\Giftcard\Http\Controllers\Concerns;

use Brainstream\Giftcard\Services\GiftCardTotals;

trait AddsGiftCardToInvoicePdf
{
    /**
     * Invoice whose PDF is being generated.
     */
    protected mixed $giftCardInvoice = null;

    /**
     * Add the gift card row to the invoice PDF before it is generated.
     */
    public function downloadPDF(string $html, ?string $fileName = null)
    {
        $giftCardTotals = app(GiftCardTotals::class);

        $order = $giftCardTotals->giftCardOrder($this->giftCardInvoice);

        if ($order) {
            $html = $giftCardTotals->addPdfRow(
                $html,
                trans('shop::app.customers.account.orders.invoice-pdf.grand-total'),
                $giftCardTotals->label($order),
                '- '.core()->formatPrice((float) $this->giftCardInvoice->giftcard_amount, $order->order_currency_code)
            );
        }

        return parent::downloadPDF($html, $fileName);
    }
}
