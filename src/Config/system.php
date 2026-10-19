<?php

return [
    [
        'key' => 'sales.gift_card',
        'name' => 'giftcard::app.admin.configuration.title',
        'info' => 'giftcard::app.admin.configuration.info',
        'icon' => 'settings/order.svg',
        'sort' => 6,
    ], [
        'key' => 'sales.gift_card.settings',
        'name' => 'giftcard::app.admin.configuration.settings.title',
        'info' => 'giftcard::app.admin.configuration.settings.info',
        'sort' => 1,
        'fields' => [
            [
                'name' => 'active',
                'title' => 'giftcard::app.admin.configuration.settings.active',
                'type' => 'boolean',
                'default' => true,
                'channel_based' => true,
            ], [
                'name' => 'min_amount',
                'title' => 'giftcard::app.admin.configuration.settings.min-amount',
                'type' => 'text',
                'validation' => 'required|numeric|min:1',
                'default' => 10,
                'channel_based' => true,
            ], [
                'name' => 'max_amount',
                'title' => 'giftcard::app.admin.configuration.settings.max-amount',
                'type' => 'text',
                'validation' => 'required|numeric|min:1',
                'default' => 500,
                'channel_based' => true,
            ], [
                'name' => 'preset_amounts',
                'title' => 'giftcard::app.admin.configuration.settings.preset-amounts',
                'info' => 'giftcard::app.admin.configuration.settings.preset-amounts-info',
                'type' => 'text',
                'default' => '25,50,100,200',
                'channel_based' => true,
            ], [
                'name' => 'validity_days',
                'title' => 'giftcard::app.admin.configuration.settings.validity-days',
                'type' => 'text',
                'validation' => 'required|integer|min:1',
                'default' => 365,
                'channel_based' => true,
            ],
        ],
    ],
];
