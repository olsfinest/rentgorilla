<?php namespace RentGorilla\Providers;

use Stripe\Stripe;
use RentGorilla\Billing\Biller;
use RentGorilla\Billing\StripeBiller;
use Illuminate\Support\ServiceProvider;

class StripeServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$api_key = config('services.stripe.secret');
		Stripe::setApiKey($api_key);
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton(Biller::class, StripeBiller::class);
	}
}
