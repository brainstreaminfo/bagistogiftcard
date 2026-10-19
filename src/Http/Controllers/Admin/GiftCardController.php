<?php

namespace Brainstream\Giftcard\Http\Controllers\Admin;

use Brainstream\Giftcard\Contracts\GiftCard;
use Brainstream\Giftcard\DataGrids\GiftCardBalanceDataGrid;
use Brainstream\Giftcard\DataGrids\GiftCardDataGrid;
use Brainstream\Giftcard\DataGrids\GiftCardPaymentDataGrid;
use Brainstream\Giftcard\Http\Requests\GiftCardRequest;
use Brainstream\Giftcard\Mail\GiftCardMail;
use Brainstream\Giftcard\Repositories\GiftCardRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Webkul\Admin\Http\Controllers\Controller;

class GiftCardController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(protected GiftCardRepository $giftCardRepository) {}

    /**
     * Display the gift card listing.
     */
    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            return datagrid(GiftCardDataGrid::class)->process();
        }

        return view('giftcard::admin.gift-cards.index');
    }

    /**
     * Display the gift card purchase payments.
     */
    public function payments(): View|JsonResponse
    {
        if (request()->ajax()) {
            return datagrid(GiftCardPaymentDataGrid::class)->process();
        }

        return view('giftcard::admin.payments.index');
    }

    /**
     * Display the gift card balances.
     */
    public function balances(): View|JsonResponse
    {
        if (request()->ajax()) {
            return datagrid(GiftCardBalanceDataGrid::class)->process();
        }

        return view('giftcard::admin.balances.index');
    }

    /**
     * Issue one or more gift cards.
     */
    public function store(GiftCardRequest $request): JsonResponse
    {
        $attributes = $request->only([
            'giftcard_amount',
            'expirationdate',
            'giftcard_status',
            'recipientname',
            'recipientemail',
            'message',
        ]);

        $attributes['sendername'] = core()->getCurrentChannel()->name;

        $attributes['senderemail'] = core()->getSenderEmailDetails()['email'] ?? null;

        for ($i = 0; $i < (int) $request->input('quantity'); $i++) {
            $giftCard = $this->giftCardRepository->create($attributes);

            if ($giftCard->recipientemail) {
                $this->sendGiftCardMail($giftCard);
            }
        }

        return new JsonResponse([
            'message' => trans('giftcard::app.admin.gift-cards.create-success'),
        ]);
    }

    /**
     * Return a gift card for the edit form.
     */
    public function edit(int $id): JsonResponse
    {
        $giftCard = $this->giftCardRepository->findOrFail($id);

        return new JsonResponse(array_merge($giftCard->toArray(), [
            'expirationdate' => $giftCard->expirationdate?->toDateString(),
        ]));
    }

    /**
     * Update a gift card.
     */
    public function update(GiftCardRequest $request, int $id): JsonResponse
    {
        $this->giftCardRepository->findOrFail($id);

        $this->giftCardRepository->update($request->only([
            'giftcard_amount',
            'expirationdate',
            'giftcard_status',
            'recipientname',
            'recipientemail',
            'message',
        ]), $id);

        return new JsonResponse([
            'message' => trans('giftcard::app.admin.gift-cards.update-success'),
        ]);
    }

    /**
     * Delete a gift card.
     */
    public function destroy(int $id): JsonResponse
    {
        $this->giftCardRepository->delete($id);

        return new JsonResponse([
            'message' => trans('giftcard::app.admin.gift-cards.delete-success'),
        ]);
    }

    /**
     * Email a gift card to its recipient without failing the request.
     */
    protected function sendGiftCardMail(GiftCard $giftCard): void
    {
        try {
            Mail::send(new GiftCardMail($giftCard));
        } catch (\Exception $e) {
            report($e);
        }
    }
}
