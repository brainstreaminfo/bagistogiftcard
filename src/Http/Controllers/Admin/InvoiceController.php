<?php

namespace Brainstream\Giftcard\Http\Controllers\Admin;

use Brainstream\Giftcard\Http\Controllers\Concerns\AddsGiftCardToInvoicePdf;
use Brainstream\Giftcard\Services\GiftCardTotals;
use Webkul\Admin\Http\Controllers\Sales\InvoiceController as BaseInvoiceController;

class InvoiceController extends BaseInvoiceController
{
    use AddsGiftCardToInvoicePdf;

    /**
     * Show the invoice with its gift card line.
     */
    public function view(int $id)
    {
        $view = parent::view($id);

        $invoice = $view->getData()['invoice'];

        $giftCardTotals = app(GiftCardTotals::class);

        $order = $giftCardTotals->giftCardOrder($invoice);

        if (! $order) {
            return $view;
        }

        return $giftCardTotals->addAdminSummaryRow(
            $view->render(),
            trans('admin::app.sales.invoices.view.grand-total'),
            core()->formatBasePrice((float) $invoice->base_grand_total),
            $giftCardTotals->label($order),
            '- '.core()->formatBasePrice((float) $invoice->base_giftcard_amount)
        );
    }

    /**
     * Print the invoice PDF with its gift card line.
     */
    public function printInvoice(int $id)
    {
        $this->giftCardInvoice = $this->invoiceRepository->find($id);

        return parent::printInvoice($id);
    }
}
