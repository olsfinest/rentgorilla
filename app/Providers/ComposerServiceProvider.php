<?php namespace RentGorilla\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
        view()->composer('partials.settings-sidebar', 'RentGorilla\Composers\SettingsComposer');
        view()->composer('partials.search-form', 'RentGorilla\Composers\SearchFormComposer');
    }

}
