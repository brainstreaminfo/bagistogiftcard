<?php

namespace Brainstream\Giftcard\DataGrids;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class GiftCardPaymentDataGrid extends DataGrid
{
    /**
     * Prepare query builder.
     *
     * @return Builder
     */
    public function prepareQueryBuilder()
    {
        return DB::table('gift_card_payments')
            ->select(
                'id',
                'giftcard_number',
                'order_id',
                'payment_id',
                'payer_email',
                'amount',
                'currency',
                'status',
                'payment_type',
                'created_at'
            );
    }

    /**
     * Prepare columns.
     *
     * @return void
     */
    public function prepareColumns()
    {
        $this->addColumn([
            'index' => 'id',
            'label' => trans('giftcard::app.admin.payments.datagrid.id'),
            'type' => 'integer',
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'giftcard_number',
            'label' => trans('giftcard::app.admin.payments.datagrid.code'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'payment_id',
            'label' => trans('giftcard::app.admin.payments.datagrid.transaction-id'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'payer_email',
            'label' => trans('giftcard::app.admin.payments.datagrid.payer-email'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'amount',
            'label' => trans('giftcard::app.admin.payments.datagrid.amount'),
            'type' => 'decimal',
            'filterable' => true,
            'sortable' => true,
            'closure' => fn ($row) => core()->formatPrice((float) $row->amount, $row->currency),
        ]);

        $this->addColumn([
            'index' => 'payment_type',
            'label' => trans('giftcard::app.admin.payments.datagrid.method'),
            'type' => 'string',
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'status',
            'label' => trans('giftcard::app.admin.payments.datagrid.status'),
            'type' => 'string',
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'created_at',
            'label' => trans('giftcard::app.admin.payments.datagrid.paid-at'),
            'type' => 'datetime',
            'filterable' => true,
            'filterable_type' => 'datetime_range',
            'sortable' => true,
        ]);
    }
}
