<?php

namespace Brainstream\Giftcard\Http\Controllers\Shop;

use Brainstream\Giftcard\Http\Controllers\Concerns\AddsGiftCardToInvoicePdf;
use Webkul\Shop\Http\Controllers\Customer\Account\OrderController as BaseOrderController;

class OrderController extends BaseOrderController
{
    use AddsGiftCardToInvoicePdf;

    /**
     * Print the invoice PDF with its gift card line.
     *
     * @param  int  $id
     */
    public function printInvoice($id)
    {
        $this->giftCardInvoice = $this->invoiceRepository->find($id);

        return parent::printInvoice($id);
    }
}
