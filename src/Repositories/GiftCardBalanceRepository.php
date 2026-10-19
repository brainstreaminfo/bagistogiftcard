<?php

namespace Brainstream\Giftcard\Repositories;

use Brainstream\Giftcard\Contracts\GiftCardBalance;
use Webkul\Core\Eloquent\Repository;

class GiftCardBalanceRepository extends Repository
{
    /**
     * Specify model class name.
     */
    public function model(): string
    {
        return GiftCardBalance::class;
    }
}
