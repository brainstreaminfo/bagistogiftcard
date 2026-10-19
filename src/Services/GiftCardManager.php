<?php

namespace Brainstream\Giftcard\Services;

use Brainstream\Giftcard\Contracts\GiftCard;
use Brainstream\Giftcard\Exceptions\InsufficientGiftCardBalanceException;
use Brainstream\Giftcard\Repositories\GiftCardBalanceRepository;
use Brainstream\Giftcard\Repositories\GiftCardRepository;
use Illuminate\Support\Facades\DB;

class GiftCardManager
{
    /**
     * Tolerance used when comparing money amounts held at four decimals.
     */
    public const EPSILON = 0.0001;

    /**
     * Create a new service instance.
     */
    public function __construct(
        protected GiftCardRepository $giftCardRepository,
        protected GiftCardBalanceRepository $giftCardBalanceRepository
    ) {}

    /**
     * Find a gift card by code when it can currently be redeemed.
     */
    public function findRedeemable(?string $code): ?GiftCard
    {
        $giftCard = $this->giftCardRepository->findByCode($code);

        if (
            ! $giftCard
            || ! $giftCard->isRedeemable()
        ) {
            return null;
        }

        return $giftCard;
    }

    /**
     * Take an amount in base currency off a gift card balance.
     *
     * @throws InsufficientGiftCardBalanceException
     */
    public function debit(string $code, float $baseAmount): void
    {
        if ($baseAmount <= 0) {
            return;
        }

        DB::transaction(function () use ($code, $baseAmount) {
            $giftCard = $this->giftCardRepository->findByCodeForUpdate($code);

            if (
                ! $giftCard
                || $giftCard->giftcard_amount + self::EPSILON < $baseAmount
            ) {
                throw new InsufficientGiftCardBalanceException(trans('giftcard::app.shop.checkout.insufficient-balance'));
            }

            $giftCard->giftcard_amount = max(0, round($giftCard->giftcard_amount - $baseAmount, 4));

            $giftCard->save();

            $this->moveUsedAmount($giftCard, $baseAmount);
        });
    }

    /**
     * Return an amount in base currency to a gift card balance.
     */
    public function credit(string $code, float $baseAmount): void
    {
        if ($baseAmount <= 0) {
            return;
        }

        DB::transaction(function () use ($code, $baseAmount) {
            $giftCard = $this->giftCardRepository->findByCodeForUpdate($code);

            if (! $giftCard) {
                return;
            }

            $giftCard->giftcard_amount = round($giftCard->giftcard_amount + $baseAmount, 4);

            $giftCard->save();

            $this->moveUsedAmount($giftCard, -$baseAmount);
        });
    }

    /**
     * Shift the used amount on the balance summary and resync it with the card.
     */
    protected function moveUsedAmount(GiftCard $giftCard, float $baseAmount): void
    {
        $balance = $this->giftCardBalanceRepository->findOneByField('giftcard_number', $giftCard->giftcard_number);

        if ($balance) {
            $balance->used_giftcard_amount = max(0, round($balance->used_giftcard_amount + $baseAmount, 4));

            $balance->save();
        }

        $this->giftCardRepository->syncBalance($giftCard);
    }
}
