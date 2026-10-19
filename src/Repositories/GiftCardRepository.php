<?php

namespace Brainstream\Giftcard\Repositories;

use Brainstream\Giftcard\Contracts\GiftCard;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Webkul\Core\Eloquent\Repository;

class GiftCardRepository extends Repository
{
    /**
     * Create a new repository instance.
     */
    public function __construct(
        protected GiftCardBalanceRepository $giftCardBalanceRepository,
        Container $container
    ) {
        parent::__construct($container);
    }

    /**
     * Specify model class name.
     */
    public function model(): string
    {
        return GiftCard::class;
    }

    /**
     * Create a gift card together with its balance summary.
     *
     * @return GiftCard
     */
    public function create(array $attributes)
    {
        Event::dispatch('giftcard.gift_card.create.before');

        $giftCard = DB::transaction(function () use ($attributes) {
            $giftCard = parent::create(array_merge([
                'giftcard_number' => $this->generateCode(),
                'creationdate' => now()->toDateString(),
            ], $attributes));

            $this->giftCardBalanceRepository->create([
                'giftcard_number' => $giftCard->giftcard_number,
                'giftcard_amount' => $giftCard->giftcard_amount,
                'used_giftcard_amount' => 0,
                'remaining_giftcard_amount' => $giftCard->giftcard_amount,
            ]);

            return $giftCard;
        });

        Event::dispatch('giftcard.gift_card.create.after', $giftCard);

        return $giftCard;
    }

    /**
     * Update a gift card and keep its balance summary in step.
     *
     * @param  int  $id
     * @return GiftCard
     */
    public function update(array $attributes, $id)
    {
        Event::dispatch('giftcard.gift_card.update.before', $id);

        $giftCard = DB::transaction(function () use ($attributes, $id) {
            $giftCard = parent::update($attributes, $id);

            $this->syncBalance($giftCard);

            return $giftCard;
        });

        Event::dispatch('giftcard.gift_card.update.after', $giftCard);

        return $giftCard;
    }

    /**
     * Delete a gift card and its balance summary.
     *
     * @param  int  $id
     * @return bool
     */
    public function delete($id)
    {
        Event::dispatch('giftcard.gift_card.delete.before', $id);

        $giftCard = $this->findOrFail($id);

        DB::transaction(function () use ($giftCard) {
            $this->giftCardBalanceRepository->deleteWhere(['giftcard_number' => $giftCard->giftcard_number]);

            $giftCard->delete();
        });

        Event::dispatch('giftcard.gift_card.delete.after', $id);

        return true;
    }

    /**
     * Find a gift card by its code.
     */
    public function findByCode(?string $code): ?GiftCard
    {
        if (blank($code)) {
            return null;
        }

        return $this->findOneByField('giftcard_number', strtoupper(trim($code)));
    }

    /**
     * Find a gift card by its code and lock the row for the running transaction.
     */
    public function findByCodeForUpdate(string $code): ?GiftCard
    {
        return $this->getModel()
            ->newQuery()
            ->where('giftcard_number', $code)
            ->lockForUpdate()
            ->first();
    }

    /**
     * Write the current amount of a gift card to its balance summary.
     */
    public function syncBalance(GiftCard $giftCard): void
    {
        $balance = $this->giftCardBalanceRepository->findOneByField('giftcard_number', $giftCard->giftcard_number);

        if (! $balance) {
            $this->giftCardBalanceRepository->create([
                'giftcard_number' => $giftCard->giftcard_number,
                'giftcard_amount' => $giftCard->giftcard_amount,
                'used_giftcard_amount' => 0,
                'remaining_giftcard_amount' => $giftCard->giftcard_amount,
            ]);

            return;
        }

        $balance->update([
            'giftcard_amount' => $balance->used_giftcard_amount + $giftCard->giftcard_amount,
            'remaining_giftcard_amount' => $giftCard->giftcard_amount,
        ]);
    }

    /**
     * Generate a unique code in the XXXX-XXXX-XXXX-XXXX format.
     */
    public function generateCode(): string
    {
        do {
            $code = implode('-', str_split(Str::upper(Str::random(16)), 4));
        } while ($this->getModel()->newQuery()->where('giftcard_number', $code)->exists());

        return $code;
    }
}
