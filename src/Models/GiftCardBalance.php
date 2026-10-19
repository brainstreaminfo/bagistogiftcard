<?php

namespace Brainstream\Giftcard\Models;

use Brainstream\Giftcard\Contracts\GiftCardBalance as GiftCardBalanceContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GiftCardBalance extends Model implements GiftCardBalanceContract
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gift_card_balances';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'giftcard_number',
        'giftcard_amount',
        'used_giftcard_amount',
        'remaining_giftcard_amount',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'giftcard_amount' => 'float',
        'used_giftcard_amount' => 'float',
        'remaining_giftcard_amount' => 'float',
    ];

    /**
     * Get the gift card the balance belongs to.
     */
    public function giftCard(): BelongsTo
    {
        return $this->belongsTo(GiftCardProxy::modelClass(), 'giftcard_number', 'giftcard_number');
    }
}
