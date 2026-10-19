<?php

namespace Brainstream\Giftcard\Models;

use Brainstream\Giftcard\Contracts\GiftCard as GiftCardContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class GiftCard extends Model implements GiftCardContract
{
    /**
     * Status of a gift card that can be redeemed.
     */
    public const STATUS_ACTIVE = '1';

    /**
     * Status of a gift card that has been switched off.
     */
    public const STATUS_INACTIVE = '0';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gift_cards';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'giftcard_number',
        'giftcard_amount',
        'giftcard_status',
        'creationdate',
        'expirationdate',
        'expirein',
        'sendername',
        'senderemail',
        'recipientname',
        'recipientemail',
        'message',
        'occasion',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'giftcard_amount' => 'float',
        'creationdate' => 'date',
        'expirationdate' => 'date',
    ];

    /**
     * Get the balance summary of the gift card.
     */
    public function balance(): HasOne
    {
        return $this->hasOne(GiftCardBalanceProxy::modelClass(), 'giftcard_number', 'giftcard_number');
    }

    /**
     * Get the payments made to purchase the gift card.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(GiftCardPaymentProxy::modelClass(), 'giftcard_number', 'giftcard_number');
    }

    /**
     * Determine whether the gift card is past its expiration date.
     */
    public function isExpired(): bool
    {
        return $this->expirationdate->endOfDay()->isPast();
    }

    /**
     * Determine whether the gift card can be applied to a cart.
     */
    public function isRedeemable(): bool
    {
        return (string) $this->giftcard_status === self::STATUS_ACTIVE
            && ! $this->isExpired()
            && $this->giftcard_amount > 0;
    }
}
