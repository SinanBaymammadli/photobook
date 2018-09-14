<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;
use \Stripe\Stripe;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Resource::withoutWrapping();
        Cashier::useCurrency('DKK', 'Kr.');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }
}
