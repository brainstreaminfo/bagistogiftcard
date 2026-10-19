<?php

namespace Brainstream\Giftcard\Providers;

use Brainstream\Giftcard\Models\GiftCard;
use Brainstream\Giftcard\Models\GiftCardBalance;
use Brainstream\Giftcard\Models\GiftCardPayment;
use Webkul\Core\Providers\CoreModuleServiceProvider;

class ModuleServiceProvider extends CoreModuleServiceProvider
{
    /**
     * Models registered with Concord for this module.
     *
     * @var array
     */
    protected $models = [
        GiftCard::class,
        GiftCardBalance::class,
        GiftCardPayment::class,
    ];
}
