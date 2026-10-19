<?php

namespace Brainstream\Giftcard\Services;

use Webkul\Sales\Contracts\Order;

class GiftCardTotals
{
    /**
     * Number of times each storefront hook has rendered in this request.
     *
     * @var array<string, int>
     */
    protected array $hookCalls = [];

    /**
     * Get the order of an order, invoice or refund when it was paid partly by gift card.
     */
    public function giftCardOrder(mixed $document): ?Order
    {
        $order = $document instanceof Order ? $document : $document?->order;

        if (
            ! $order?->giftcard_number
            || (float) $document->base_giftcard_amount <= 0
        ) {
            return null;
        }

        return $order;
    }

    /**
     * Get the gift card label shown beside the amount.
     */
    public function label(Order $order): string
    {
        return trans('giftcard::app.shop.order.gift-card', ['code' => $order->giftcard_number]);
    }

    /**
     * Get the next invoice or refund for a storefront hook rendered once per layout inside its loop.
     */
    public function nextForStorefrontHook(string $relation, int $layoutsPerItem = 2): mixed
    {
        $order = auth()->guard('customer')->user()?->orders()->find(request()->route('id'));

        $call = $this->hookCalls[$relation] = ($this->hookCalls[$relation] ?? -1) + 1;

        return $order?->{$relation}->values()->get(intdiv($call, $layoutsPerItem));
    }

    /**
     * Insert a row above the grand total of an order email.
     */
    public function addEmailRow(string $html, string $grandTotalLabel, string $code, string $amount): string
    {
        $pattern = '/<div style="([^"]*?)font-weight:\s*bold;?([^"]*)">(\s*<span>\s*(?:'.$this->labelPattern($grandTotalLabel).')\s*<\/span>)/u';

        if (! preg_match_all($pattern, $html, $matches, PREG_OFFSET_CAPTURE)) {
            return $html;
        }

        $last = count($matches[0]) - 1;

        $row = '<div style="'.rtrim($matches[1][$last][0].$matches[2][$last][0], '; ').'">'
            .'<span>'.e(trans('giftcard::app.admin.sales.gift-card'))
            .'<br><span style="font-size: 13px; color: #6b7280; letter-spacing: 0.5px;">'.e($code).'</span></span>'
            .'<span style="text-align: right;">'.e($amount).'</span>'
            .'</div>';

        return substr_replace($html, $row, $matches[0][$last][1], 0);
    }

    /**
     * Insert a row into the two column summary of an admin invoice or refund page.
     */
    public function addAdminSummaryRow(string $html, string $grandTotalLabel, string $grandTotal, string $label, string $amount): string
    {
        $labelPattern = '/<p class="([^"]*font-semibold[^"]*)">\s*(?:'.$this->labelPattern($grandTotalLabel).')\s*<\/p>/u';

        if (! preg_match($labelPattern, $html, $labelMatch, PREG_OFFSET_CAPTURE)) {
            return $html;
        }

        $valuePattern = '/<p class="[^"]*font-semibold[^"]*">\s*'.preg_quote($grandTotal, '/').'\s*<\/p>/u';

        if (! preg_match_all($valuePattern, $html, $valueMatches, PREG_OFFSET_CAPTURE, $labelMatch[0][1])) {
            return $html;
        }

        $class = trim(preg_replace('/\s+/', ' ', str_replace(
            ['text-base', 'font-semibold', 'text-gray-800', 'dark:text-white'],
            '',
            $labelMatch[1][0]
        )).' text-gray-600 dark:text-gray-300');

        $valueOffset = $valueMatches[0][count($valueMatches[0]) - 1][1];

        $html = substr_replace($html, '<p class="'.$class.'">'.e($amount).'</p>', $valueOffset, 0);

        return substr_replace($html, '<p class="'.$class.'">'.e($label).'</p>', $labelMatch[0][1], 0);
    }

    /**
     * Insert a row above the grand total of the invoice PDF.
     */
    public function addPdfRow(string $html, string $grandTotalLabel, string $label, string $amount): string
    {
        $pattern = '/<tr>(\s*<td[^>]*>\s*<b>\s*(?:'.$this->labelPattern($grandTotalLabel).')\s*<\/b>)/u';

        if (! preg_match_all($pattern, $html, $matches, PREG_OFFSET_CAPTURE)) {
            return $html;
        }

        $row = '<tr><td>'.e($label).'</td><td>-</td><td>'.e($amount).'</td></tr>';

        return substr_replace($html, $row, $matches[0][count($matches[0]) - 1][1], 0);
    }

    /**
     * Build a regex alternative matching a translated label raw or HTML escaped.
     */
    protected function labelPattern(string $label): string
    {
        return implode('|', array_unique([preg_quote($label, '/'), preg_quote(e($label), '/')]));
    }
}
