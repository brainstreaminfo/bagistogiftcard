<?php

namespace Brainstream\Giftcard\Models;

use Brainstream\Giftcard\Contracts\GiftCardPayment as GiftCardPaymentContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GiftCardPayment extends Model implements GiftCardPaymentContract
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gift_card_payments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'giftcard_number',
        'order_id',
        'payment_id',
        'payer_id',
        'payer_email',
        'amount',
        'currency',
        'status',
        'payment_data',
        'payment_type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'float',
        'payment_data' => 'array',
    ];

    /**
     * Get the gift card that was purchased.
     */
    public function giftCard(): BelongsTo
    {
        return $this->belongsTo(GiftCardProxy::modelClass(), 'giftcard_number', 'giftcard_number');
    }
}
