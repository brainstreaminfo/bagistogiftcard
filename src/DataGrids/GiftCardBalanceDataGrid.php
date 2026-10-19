<?php

namespace Brainstream\Giftcard\DataGrids;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class GiftCardBalanceDataGrid extends DataGrid
{
    /**
     * Prepare query builder.
     *
     * @return Builder
     */
    public function prepareQueryBuilder()
    {
        return DB::table('gift_card_balances')
            ->select(
                'id',
                'giftcard_number',
                'giftcard_amount',
                'used_giftcard_amount',
                'remaining_giftcard_amount',
                'updated_at'
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
            'label' => trans('giftcard::app.admin.balances.datagrid.id'),
            'type' => 'integer',
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'giftcard_number',
            'label' => trans('giftcard::app.admin.balances.datagrid.code'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'giftcard_amount',
            'label' => trans('giftcard::app.admin.balances.datagrid.total'),
            'type' => 'decimal',
            'filterable' => true,
            'sortable' => true,
            'closure' => fn ($row) => core()->formatBasePrice((float) $row->giftcard_amount),
        ]);

        $this->addColumn([
            'index' => 'used_giftcard_amount',
            'label' => trans('giftcard::app.admin.balances.datagrid.used'),
            'type' => 'decimal',
            'filterable' => true,
            'sortable' => true,
            'closure' => fn ($row) => core()->formatBasePrice((float) $row->used_giftcard_amount),
        ]);

        $this->addColumn([
            'index' => 'remaining_giftcard_amount',
            'label' => trans('giftcard::app.admin.balances.datagrid.remaining'),
            'type' => 'decimal',
            'filterable' => true,
            'sortable' => true,
            'closure' => fn ($row) => core()->formatBasePrice((float) $row->remaining_giftcard_amount),
        ]);

        $this->addColumn([
            'index' => 'updated_at',
            'label' => trans('giftcard::app.admin.balances.datagrid.updated-at'),
            'type' => 'datetime',
            'filterable' => true,
            'filterable_type' => 'datetime_range',
            'sortable' => true,
        ]);
    }
}
