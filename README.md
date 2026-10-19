[![Bagisto 2.4](https://img.shields.io/badge/Bagisto-2.4-blue)](https://github.com/brainstreaminfo/bagistogiftcard/releases/tag/v2.4.0)
[![Bagisto 2.5](https://img.shields.io/badge/Bagisto-2.5-blue)](https://github.com/brainstreaminfo/bagistogiftcard/releases/tag/v2.5.0)
[![PHP 8.3+](https://img.shields.io/badge/PHP-8.3%2B-777bb4)](https://www.php.net/)
[![License: MIT](https://img.shields.io/badge/License-MIT-green)](composer.json)

# Introduction:

The Bagisto gift card extension lets customers buy gift cards for any occasion, send them by email, and redeem them at checkout. Store admins can also issue gift cards, track every purchase payment and follow each card's balance.

# Features

* **Occasion themes:** birthdays, anniversaries, Christmas, Diwali and 19 more, with a matching image and greeting in the email.
* **Purchase with PayPal:** buyers pay through Bagisto's PayPal Smart Button configuration. The payment is captured and verified on the server before a card is issued.
* **Email delivery:** the recipient receives the code, balance, expiry date and personal message.
* **Redeem at checkout:** apply a code on the cart or checkout page. Partial redemption keeps the remaining balance on the card.
* **Correct accounting:** the balance is deducted when the order is placed. Invoices and refunds stay net of the gift card. Refunds and cancellations return the gift card share to the card.
* **Admin tools:** create, edit and delete gift cards, and view purchase payments and balances, all behind role permissions.
* **Configurable:** turn purchases on or off and set the minimum, maximum and preset amounts and the validity period per channel.
* **22 languages:** every locale Bagisto ships with.

# Requirements:

* Bagisto: v2.4.x, v2.5.x
* PHP: 8.3 or higher

| Bagisto | Extension tag |
|---|---|
| 2.4.x | [v2.4.0](https://github.com/brainstreaminfo/bagistogiftcard/tree/v2.4.0) |
| 2.5.x | [v2.5.0](https://github.com/brainstreaminfo/bagistogiftcard/tree/v2.5.0) |
| 2.0 – 2.2 | [v2.2.3](https://github.com/brainstreaminfo/bagistogiftcard/tree/v2.2.3) |

# Installation:

1. Copy the extension into `packages/Brainstream/Giftcard` in the project root.

2. Add the namespace to `autoload.psr-4` in the root `composer.json`:

```json
"Brainstream\\Giftcard\\": "packages/Brainstream/Giftcard/src"
```

3. Register the service provider in `bootstrap/providers.php`:

```php
Brainstream\Giftcard\Providers\GiftcardServiceProvider::class,
```

4. Register the module in the `modules` array of `config/concord.php`:

```php
Brainstream\Giftcard\Providers\ModuleServiceProvider::class,
```

5. Run:

```bash
composer dump-autoload
php artisan migrate
php artisan vendor:publish --tag=giftcard-assets --force
php artisan optimize:clear
```

# Configuration:

* **Purchases:** go to *Configure → Sales → Gift Cards* and set the amounts and validity.
* **PayPal:** buying gift cards requires *Configure → Sales → Payment Methods → PayPal Smart Button* to be active, with a client ID and secret. The store's base currency must be one of its accepted currencies.
* **Email:** configure the outgoing mail settings so recipients receive their gift cards.

# Upgrading from v2.2.x:

Replace the package files, update the registrations above, and run `php artisan migrate`. The new migration converts existing tables in place and keeps all gift cards and balances. Remove the `CartResource` change and the views published by the old version from `resources/views/vendor/admin` and `resources/views/vendor/shop`. They are no longer used and would override the current core views.
