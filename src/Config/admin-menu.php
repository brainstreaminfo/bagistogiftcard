<?php

return [
    [
        'key' => 'giftcard',
        'name' => 'giftcard::app.admin.menu.title',
        'route' => 'admin.gift_cards.index',
        'sort' => 4,
        'icon' => 'icon-sales',
    ], [
        'key' => 'giftcard.gift_cards',
        'name' => 'giftcard::app.admin.menu.gift-cards',
        'route' => 'admin.gift_cards.index',
        'sort' => 1,
        'icon' => '',
    ], [
        'key' => 'giftcard.payments',
        'name' => 'giftcard::app.admin.menu.payments',
        'route' => 'admin.gift_cards.payments.index',
        'sort' => 2,
        'icon' => '',
    ], [
        'key' => 'giftcard.balances',
        'name' => 'giftcard::app.admin.menu.balances',
        'route' => 'admin.gift_cards.balances.index',
        'sort' => 3,
        'icon' => '',
    ],
];
