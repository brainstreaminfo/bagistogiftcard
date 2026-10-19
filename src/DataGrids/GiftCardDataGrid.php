<?php

namespace Brainstream\Giftcard\DataGrids;

use Brainstream\Giftcard\Models\GiftCard;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class GiftCardDataGrid extends DataGrid
{
    /**
     * Prepare query builder.
     *
     * @return Builder
     */
    public function prepareQueryBuilder()
    {
        return DB::table('gift_cards')
            ->select(
                'id',
                'giftcard_number',
                'giftcard_amount',
                'giftcard_status',
                'recipientname',
                'recipientemail',
                'creationdate',
                'expirationdate'
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
            'label' => trans('giftcard::app.admin.gift-cards.datagrid.id'),
            'type' => 'integer',
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'giftcard_number',
            'label' => trans('giftcard::app.admin.gift-cards.datagrid.code'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'giftcard_amount',
            'label' => trans('giftcard::app.admin.gift-cards.datagrid.balance'),
            'type' => 'decimal',
            'filterable' => true,
            'sortable' => true,
            'closure' => fn ($row) => core()->formatBasePrice((float) $row->giftcard_amount),
        ]);

        $this->addColumn([
            'index' => 'recipientemail',
            'label' => trans('giftcard::app.admin.gift-cards.datagrid.recipient'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
            'closure' => fn ($row) => $row->recipientemail ?: '-',
        ]);

        $this->addColumn([
            'index' => 'giftcard_status',
            'label' => trans('giftcard::app.admin.gift-cards.datagrid.status'),
            'type' => 'string',
            'filterable' => true,
            'filterable_type' => 'dropdown',
            'filterable_options' => [
                [
                    'label' => trans('giftcard::app.admin.gift-cards.datagrid.active'),
                    'value' => GiftCard::STATUS_ACTIVE,
                ], [
                    'label' => trans('giftcard::app.admin.gift-cards.datagrid.inactive'),
                    'value' => GiftCard::STATUS_INACTIVE,
                ],
            ],
            'sortable' => true,
            'closure' => fn ($row) => (string) $row->giftcard_status === GiftCard::STATUS_ACTIVE
                ? '<p class="label-active">'.trans('giftcard::app.admin.gift-cards.datagrid.active').'</p>'
                : '<p class="label-canceled">'.trans('giftcard::app.admin.gift-cards.datagrid.inactive').'</p>',
        ]);

        $this->addColumn([
            'index' => 'creationdate',
            'label' => trans('giftcard::app.admin.gift-cards.datagrid.created-on'),
            'type' => 'date',
            'filterable' => true,
            'filterable_type' => 'date_range',
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'expirationdate',
            'label' => trans('giftcard::app.admin.gift-cards.datagrid.expires-on'),
            'type' => 'date',
            'filterable' => true,
            'filterable_type' => 'date_range',
            'sortable' => true,
        ]);
    }

    /**
     * Prepare actions.
     *
     * @return void
     */
    public function prepareActions()
    {
        if (bouncer()->hasPermission('giftcard.gift_cards.edit')) {
            $this->addAction([
                'index' => 'edit',
                'icon' => 'icon-edit',
                'title' => trans('giftcard::app.admin.gift-cards.datagrid.edit'),
                'method' => 'GET',
                'url' => fn ($row) => route('admin.gift_cards.edit', $row->id),
            ]);
        }

        if (bouncer()->hasPermission('giftcard.gift_cards.delete')) {
            $this->addAction([
                'index' => 'delete',
                'icon' => 'icon-delete',
                'title' => trans('giftcard::app.admin.gift-cards.datagrid.delete'),
                'method' => 'DELETE',
                'url' => fn ($row) => route('admin.gift_cards.delete', $row->id),
            ]);
        }
    }
}
