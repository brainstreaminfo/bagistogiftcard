<?php

namespace Brainstream\Giftcard\Http\Controllers\Admin;

use Brainstream\Giftcard\Services\GiftCardTotals;
use Webkul\Admin\Http\Controllers\Sales\RefundController as BaseRefundController;

class RefundController extends BaseRefundController
{
    /**
     * Show the refund with the part returned to the gift card.
     *
     * @param  int  $id
     */
    public function view($id)
    {
        $view = parent::view($id);

        $refund = $view->getData()['refund'];

        $giftCardTotals = app(GiftCardTotals::class);

        $order = $giftCardTotals->giftCardOrder($refund);

        if (! $order) {
            return $view;
        }

        return $giftCardTotals->addAdminSummaryRow(
            $view->render(),
            trans('admin::app.sales.refunds.view.grand-total'),
            core()->formatBasePrice((float) $refund->base_grand_total),
            $giftCardTotals->label($order),
            '- '.core()->formatBasePrice((float) $refund->base_giftcard_amount)
        );
    }
}
