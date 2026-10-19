<?php

return [
    [
        'key' => 'giftcard',
        'name' => 'giftcard::app.admin.acl.title',
        'route' => 'admin.gift_cards.index',
        'sort' => 4,
    ], [
        'key' => 'giftcard.gift_cards',
        'name' => 'giftcard::app.admin.acl.gift-cards',
        'route' => 'admin.gift_cards.index',
        'sort' => 1,
    ], [
        'key' => 'giftcard.gift_cards.create',
        'name' => 'giftcard::app.admin.acl.create',
        'route' => 'admin.gift_cards.store',
        'sort' => 1,
    ], [
        'key' => 'giftcard.gift_cards.edit',
        'name' => 'giftcard::app.admin.acl.edit',
        'route' => [
            'admin.gift_cards.edit',
            'admin.gift_cards.update',
        ],
        'sort' => 2,
    ], [
        'key' => 'giftcard.gift_cards.delete',
        'name' => 'giftcard::app.admin.acl.delete',
        'route' => 'admin.gift_cards.delete',
        'sort' => 3,
    ], [
        'key' => 'giftcard.payments',
        'name' => 'giftcard::app.admin.acl.payments',
        'route' => 'admin.gift_cards.payments.index',
        'sort' => 2,
    ], [
        'key' => 'giftcard.balances',
        'name' => 'giftcard::app.admin.acl.balances',
        'route' => 'admin.gift_cards.balances.index',
        'sort' => 3,
    ],
];
