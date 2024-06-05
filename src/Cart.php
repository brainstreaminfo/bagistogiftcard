<?php

namespace Webkul\Giftcard;

use Webkul\Checkout\Cart as BaseCart;
use Webkul\Checkout\Traits\CartCoupons;
use Webkul\Giftcard\Traits\GiftCardOverrides;

class Cart extends BaseCart
{
    use CartCoupons, GiftCardOverrides {
        // Use methods from GiftCardOverrides instead of CartCoupons
        GiftCardOverrides::setGiftCardCode insteadof CartCoupons;
        GiftCardOverrides::removeGiftCardCode insteadof CartCoupons;
    }
}
