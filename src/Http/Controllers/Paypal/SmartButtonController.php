<?php

namespace Brainstream\Giftcard\Http\Controllers\Paypal;

use Webkul\Checkout\Facades\Cart;
use Webkul\Paypal\Http\Controllers\SmartButtonController as BaseSmartButtonController;

class SmartButtonController extends BaseSmartButtonController
{
    /**
     * Build the PayPal order body with the applied gift card counted as a discount.
     *
     * @return array
     */
    protected function buildRequestBody()
    {
        $data = parent::buildRequestBody();

        $giftCardAmount = (float) Cart::getCart()?->giftcard_amount;

        if ($giftCardAmount <= 0) {
            return $data;
        }

        $amount = &$data['purchase_units'][0]['amount'];

        $amount['value'] = $this->smartButton->formatCurrencyValue((float) $amount['value'] - $giftCardAmount);

        $amount['breakdown']['discount']['value'] = $this->smartButton->formatCurrencyValue(
            (float) $amount['breakdown']['discount']['value'] + $giftCardAmount
        );

        return $data;
    }
}
