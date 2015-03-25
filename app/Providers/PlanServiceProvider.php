<?php namespace RentGorilla\Providers;

use Illuminate\Support\ServiceProvider;

class PlanServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'subscription',
            'RentGorilla\Plans\PlanService'
        );

    }

}
