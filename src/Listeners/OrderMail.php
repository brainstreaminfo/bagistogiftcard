<?php

namespace Brainstream\Giftcard\Listeners;

use Brainstream\Giftcard\Services\GiftCardTotals;
use Illuminate\Mail\Events\MessageSending;

class OrderMail
{
    /**
     * Core order emails that show totals, with the translation key of their grand total label.
     *
     * @var array<string, string>
     */
    protected array $mails = [
        'Webkul\Shop\Mail\Order\CreatedNotification' => 'shop::app.emails.orders.grand-total',
        'Webkul\Shop\Mail\Order\InvoicedNotification' => 'shop::app.emails.orders.grand-total',
        'Webkul\Shop\Mail\Order\RefundedNotification' => 'shop::app.emails.orders.grand-total',
        'Webkul\Shop\Mail\Order\CanceledNotification' => 'shop::app.emails.orders.grand-total',
        'Webkul\Admin\Mail\Order\CreatedNotification' => 'admin::app.emails.orders.grand-total',
        'Webkul\Admin\Mail\Order\InvoicedNotification' => 'admin::app.emails.orders.grand-total',
        'Webkul\Admin\Mail\Order\RefundedNotification' => 'admin::app.emails.orders.grand-total',
        'Webkul\Admin\Mail\Order\CanceledNotification' => 'admin::app.emails.orders.grand-total',
    ];

    /**
     * Create a new listener instance.
     */
    public function __construct(protected GiftCardTotals $giftCardTotals) {}

    /**
     * Add the gift card line above the grand total of an order email.
     */
    public function addGiftCardLine(MessageSending $event): void
    {
        $mailable = $event->data['__laravel_mailable'] ?? null;

        if (! isset($this->mails[$mailable])) {
            return;
        }

        $document = $event->data['invoice'] ?? $event->data['refund'] ?? $event->data['order'] ?? null;

        $order = $this->giftCardTotals->giftCardOrder($document);

        $html = $event->message->getHtmlBody();

        if (
            ! $order
            || ! is_string($html)
        ) {
            return;
        }

        $amount = str_starts_with($mailable, 'Webkul\Admin\\')
            ? core()->formatBasePrice((float) $document->base_giftcard_amount)
            : core()->formatPrice((float) $document->giftcard_amount, $order->order_currency_code);

        $updated = $this->giftCardTotals->addEmailRow($html, trans($this->mails[$mailable]), $order->giftcard_number, '- '.$amount);

        if ($updated !== $html) {
            $event->message->html($updated);
        }
    }
}
