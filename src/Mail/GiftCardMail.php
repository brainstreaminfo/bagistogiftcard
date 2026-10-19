<?php

namespace Brainstream\Giftcard\Mail;

use Brainstream\Giftcard\Contracts\GiftCard;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Webkul\Shop\Mail\Mailable;

class GiftCardMail extends Mailable
{
    /**
     * Create a new message instance.
     */
    public function __construct(public GiftCard $giftCard) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            to: [
                new Address(
                    $this->giftCard->recipientemail,
                    (string) $this->giftCard->recipientname
                ),
            ],
            subject: trans('giftcard::app.emails.gift-card.subject', [
                'sender' => $this->giftCard->sendername ?: core()->getCurrentChannel()->name,
            ]),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'giftcard::emails.gift-card',
        );
    }
}
