<?php

namespace Payments\Helper\Providers;

use Illuminate\Support\ServiceProvider;
use YourVendor\PaymobPackage\Services\Paymob;

class PaymobServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Paymob::class, function ($app) {
            return new Paymob();
        });
    }

    public function boot()
    {
        // نشر الإعدادات (config)
        $this->publishes([
            __DIR__ . '/../../config/paymob.php' => config_path('paymob.php'),
        ], 'config');
    }
}
