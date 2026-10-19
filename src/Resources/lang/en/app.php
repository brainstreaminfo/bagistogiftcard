<?php

return [
    'admin' => [
        'menu' => [
            'title' => 'Gift Cards',
            'gift-cards' => 'Gift Cards',
            'payments' => 'Payments',
            'balances' => 'Balances',
        ],

        'acl' => [
            'title' => 'Gift Cards',
            'gift-cards' => 'Gift Cards',
            'create' => 'Create',
            'edit' => 'Edit',
            'delete' => 'Delete',
            'payments' => 'Payments',
            'balances' => 'Balances',
        ],

        'gift-cards' => [
            'title' => 'Gift Cards',
            'create-btn' => 'Create Gift Card',
            'create-success' => 'Gift card created successfully.',
            'update-success' => 'Gift card updated successfully.',
            'delete-success' => 'Gift card deleted successfully.',

            'datagrid' => [
                'id' => 'ID',
                'code' => 'Code',
                'balance' => 'Balance',
                'recipient' => 'Recipient',
                'status' => 'Status',
                'active' => 'Active',
                'inactive' => 'Inactive',
                'created-on' => 'Created On',
                'expires-on' => 'Expires On',
                'edit' => 'Edit',
                'delete' => 'Delete',
            ],

            'form' => [
                'create-title' => 'Create Gift Card',
                'edit-title' => 'Edit Gift Card',
                'code' => 'Code',
                'amount' => 'Balance (:currency)',
                'quantity' => 'Quantity',
                'expires-on' => 'Expires On',
                'status' => 'Status',
                'recipient-name' => 'Recipient Name',
                'recipient-email' => 'Recipient Email',
                'message' => 'Message',
                'email-note' => 'When a recipient email is given, each gift card is emailed to the recipient.',
                'save-btn' => 'Save Gift Card',
            ],
        ],

        'payments' => [
            'title' => 'Gift Card Payments',

            'datagrid' => [
                'id' => 'ID',
                'code' => 'Gift Card Code',
                'transaction-id' => 'Transaction ID',
                'payer-email' => 'Payer Email',
                'amount' => 'Amount',
                'method' => 'Method',
                'status' => 'Status',
                'paid-at' => 'Paid At',
            ],
        ],

        'balances' => [
            'title' => 'Gift Card Balances',

            'datagrid' => [
                'id' => 'ID',
                'code' => 'Gift Card Code',
                'total' => 'Total Value',
                'used' => 'Used',
                'remaining' => 'Remaining',
                'updated-at' => 'Updated At',
            ],
        ],

        'sales' => [
            'gift-card' => 'Gift Card',
            'gift-card-code' => 'Gift Card Code',
        ],

        'configuration' => [
            'title' => 'Gift Cards',
            'info' => 'Configure gift card purchases on the storefront.',

            'settings' => [
                'title' => 'Settings',
                'info' => 'Enable gift card purchases and set the amounts customers can buy.',
                'active' => 'Allow Gift Card Purchases',
                'min-amount' => 'Minimum Amount',
                'max-amount' => 'Maximum Amount',
                'preset-amounts' => 'Preset Amounts',
                'preset-amounts-info' => 'Comma separated amounts offered as quick choices, e.g. 25,50,100.',
                'validity-days' => 'Validity (Days)',
            ],
        ],
    ],

    'shop' => [
        'header-link' => 'Gift Cards',

        'purchase' => [
            'title' => 'Gift Cards',
            'description' => 'Send a gift card by email for any occasion.',
            'choose-occasion' => 'Choose an Occasion',
            'details' => 'Gift Card Details',
            'amount' => 'Amount (:currency)',
            'amount-range' => 'Enter an amount between :min and :max.',
            'recipient-name' => 'Recipient Name',
            'recipient-email' => 'Recipient Email',
            'sender-name' => 'Your Name',
            'sender-email' => 'Your Email',
            'message' => 'Personal Message',
            'preview' => 'Preview',
            'back' => 'Back',
            'next' => 'Next',
            'pay' => 'Pay with PayPal',
            'unavailable' => 'Gift cards cannot be purchased at the moment.',
            'currency-unsupported' => 'Gift cards cannot be paid in :currency.',
            'payment-failed' => 'The payment could not be completed. You have not been charged.',
            'session-expired' => 'Your gift card details expired. Please fill in the form again.',
            'required' => 'This field is required.',
            'invalid-email' => 'Please enter a valid email address.',
            'fix-errors' => 'Please correct the highlighted fields.',
        ],

        'occasions' => [
            'welcome' => 'Welcome',
            'birthday' => 'Birthday',
            'christmas' => 'Christmas',
            'anniversary' => 'Anniversary',
            'pongal' => 'Pongal',
            'ramadan' => 'Ramadan',
            'diwali' => 'Diwali',
            'engagement' => 'Engagement',
            'farewell' => 'Farewell',
            'navratri' => 'Navratri',
            'rakshabandhan' => 'Raksha Bandhan',
            'onam' => 'Onam',
            'fathers-day' => 'Father\'s Day',
            'mothers-day' => 'Mother\'s Day',
            'congratulations' => 'Congratulations',
            'easter' => 'Easter',
            'best-mom' => 'Best Mom',
            'best-dad' => 'Best Dad',
            'bhai-dooj' => 'Bhai Dooj',
            'thank-you' => 'Thank You',
            'valentines-day' => 'Valentine\'s Day',
            'good-luck' => 'Good Luck',
            'grandparents-day' => 'Grandparents Day',
            'holi' => 'Holi',
        ],

        'greetings' => [
            'welcome' => 'Welcome to our community!',
            'birthday' => 'Have a fantastic birthday! Enjoy your day!',
            'christmas' => 'Merry Christmas! Wishing you joy and happiness!',
            'anniversary' => 'Happy anniversary! Cheers to many more years!',
            'pongal' => 'Happy Pongal! Enjoy the festive season!',
            'ramadan' => 'Ramadan Mubarak! May your fast be easy and your blessings many!',
            'diwali' => 'Happy Diwali! May your life be filled with light and happiness!',
            'engagement' => 'Congratulations on your engagement!',
            'farewell' => 'Farewell and best wishes for your future!',
            'navratri' => 'Happy Navratri! May you be blessed with good health and happiness!',
            'rakshabandhan' => 'Happy Raksha Bandhan! Celebrating the bond of love!',
            'onam' => 'Happy Onam! Wishing you a joyous and prosperous year ahead!',
            'fathers-day' => 'Happy Father\'s Day! Thank you for everything!',
            'mothers-day' => 'Happy Mother\'s Day! You are the best!',
            'congratulations' => 'Congratulations on your achievement!',
            'easter' => 'Happy Easter! Wishing you a joyful and blessed holiday!',
            'best-mom' => 'You are the best mom!',
            'best-dad' => 'You are the best dad!',
            'bhai-dooj' => 'Happy Bhai Dooj! Celebrating the bond between siblings!',
            'thank-you' => 'Thank you for everything!',
            'valentines-day' => 'Happy Valentine\'s Day! Sending you all my love!',
            'good-luck' => 'Good luck in all your future endeavours!',
            'grandparents-day' => 'Happy Grandparents Day! We love you!',
            'holi' => 'Happy Holi! May your life be full of colours!',
        ],

        'success' => [
            'title' => 'Thank You!',
            'message' => 'Your gift card worth :amount has been sent to :email.',
            'continue-shopping' => 'Continue Shopping',
        ],

        'checkout' => [
            'title' => 'Gift Card',
            'placeholder' => 'Enter gift card code',
            'apply' => 'Apply',
            'remove' => 'Remove',
            'applied' => 'Gift Card (:code)',
            'remaining' => 'Remaining balance after this order: :amount',
            'apply-success' => 'Gift card applied successfully.',
            'remove-success' => 'Gift card removed successfully.',
            'invalid' => 'This gift card is invalid, expired or has no balance left.',
            'cart-not-found' => 'Your cart is empty.',
            'insufficient-balance' => 'The gift card balance has changed. Please review your order and try again.',
        ],

        'order' => [
            'gift-card' => 'Gift Card (:code)',
        ],
    ],

    'emails' => [
        'gift-card' => [
            'subject' => ':sender has sent you a gift card',
            'greeting' => 'Hi :name,',
            'intro' => ':sender has sent you a gift card worth :amount.',
            'code' => 'Your gift card code',
            'expires' => 'Valid until :date',
            'redeem' => 'Enter this code in the gift card box at checkout to redeem it.',
            'shop-now' => 'Shop Now',
        ],
    ],
];
