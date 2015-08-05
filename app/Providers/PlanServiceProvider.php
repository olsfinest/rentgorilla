<?php namespace RentGorilla\Providers;

use Illuminate\Support\ServiceProvider;
use RentGorilla\Plans\PlanService;

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


        $this->app->bind('subscription', function() {
            $repo = $this->app->make('RentGorilla\Repositories\PlanRepository');
            return new PlanService($repo);
        });

    }

}
