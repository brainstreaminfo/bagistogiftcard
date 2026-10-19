<?php

namespace Brainstream\Giftcard\Repositories;

use Brainstream\Giftcard\Contracts\GiftCardPayment;
use Webkul\Core\Eloquent\Repository;

class GiftCardPaymentRepository extends Repository
{
    /**
     * Specify model class name.
     */
    public function model(): string
    {
        return GiftCardPayment::class;
    }
}
