<?php

namespace Brainstream\Giftcard\Providers;

use Brainstream\Giftcard\Http\Controllers\Paypal\SmartButtonController;
use Brainstream\Giftcard\Listeners\GiftCard;
use Brainstream\Giftcard\Observers\InvoiceObserver;
use Brainstream\Giftcard\Observers\OrderObserver;
use Brainstream\Giftcard\Observers\RefundObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Webkul\Paypal\Http\Controllers\SmartButtonController as BaseSmartButtonController;
use Webkul\Sales\Models\InvoiceProxy;
use Webkul\Sales\Models\OrderProxy;
use Webkul\Sales\Models\RefundProxy;

class GiftcardServiceProvider extends ServiceProvider
{
    /**
     * View templates rendered into core view render events.
     *
     * @var array<string, string>
     */
    protected array $viewRenderEvents = [
        'bagisto.shop.layout.head.after' => 'giftcard::shop.layouts.style',
        'bagisto.shop.components.layouts.header.desktop.bottom.compare.before' => 'giftcard::shop.components.header-link',
        'bagisto.shop.components.layouts.header.mobile.compare.before' => 'giftcard::shop.components.header-link',
        'bagisto.shop.checkout.cart.summary.coupon.after' => 'giftcard::shop.checkout.gift-card',
        'bagisto.shop.checkout.onepage.summary.coupon.after' => 'giftcard::shop.checkout.gift-card',
        'bagisto.shop.customers.account.orders.view.information.discount.after' => 'giftcard::shop.customers.orders.gift-card',
        'bagisto.admin.sales.order.view.discount.after' => 'giftcard::admin.sales.orders.gift-card',
    ];

    /**
     * Register package services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(dirname(__DIR__).'/Config/admin-menu.php', 'menu.admin');

        $this->mergeConfigFrom(dirname(__DIR__).'/Config/acl.php', 'acl');

        $this->mergeConfigFrom(dirname(__DIR__).'/Config/system.php', 'core');

        $this->mergeConfigFrom(dirname(__DIR__).'/Config/occasions.php', 'giftcard.occasions');

        $this->app->bind(BaseSmartButtonController::class, SmartButtonController::class);
    }

    /**
     * Bootstrap package services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        $this->loadRoutesFrom(__DIR__.'/../Routes/admin-routes.php');

        $this->loadRoutesFrom(__DIR__.'/../Routes/shop-routes.php');

        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'giftcard');

        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'giftcard');

        $this->publishes([
            __DIR__.'/../Resources/assets' => public_path('vendor/giftcard'),
        ], 'giftcard-assets');

        $this->registerEventListeners();

        $this->registerModelObservers();
    }

    /**
     * Register the event listeners of the package.
     */
    protected function registerEventListeners(): void
    {
        Event::listen('checkout.cart.collect.totals.after', [GiftCard::class, 'applyToCart']);

        Event::listen('sales.order.cancel.after', [GiftCard::class, 'restoreFromCanceledOrder']);

        foreach ($this->viewRenderEvents as $event => $template) {
            Event::listen($event, fn ($viewRenderEventManager) => $viewRenderEventManager->addTemplate($template));
        }
    }

    /**
     * Register the sales model observers that keep gift card amounts in step.
     */
    protected function registerModelObservers(): void
    {
        OrderProxy::observe(OrderObserver::class);

        InvoiceProxy::observe(InvoiceObserver::class);

        RefundProxy::observe(RefundObserver::class);
    }
}
