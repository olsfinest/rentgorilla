<?php namespace RentGorilla\Providers;

use Illuminate\Support\ServiceProvider;
use RentGorilla\Repositories\LaravelConfigPlanRepository;

class AppServiceProvider extends ServiceProvider {

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
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'RentGorilla\Services\Registrar'
		);

        $this->app->bind('RentGorilla\Repositories\PlanRepository', function($app) {
                return new LaravelConfigPlanRepository(config('plans.plans'));
            }
        );

		$this->app->bind(
			'RentGorilla\Repositories\RentalRepository',
			'RentGorilla\Repositories\EloquentRentalRepository'
		);

        $this->app->bind(
            'RentGorilla\Repositories\UserRepository',
            'RentGorilla\Repositories\EloquentUserRepository'
        );

        $this->app->bind(
            'RentGorilla\Repositories\FavouritesRepository',
            'RentGorilla\Repositories\EloquentFavouritesRepository'
        );

        $this->app->bind(
            'RentGorilla\Repositories\ProfileRepository',
            'RentGorilla\Repositories\EloquentProfileRepository'
        );

        $this->app->bind(
            'RentGorilla\Repositories\PhotoRepository',
            'RentGorilla\Repositories\EloquentPhotoRepository'
        );

        $this->app->bind(
            'RentGorilla\Repositories\LikeRepository',
            'RentGorilla\Repositories\EloquentLikeRepository'
        );

        $this->app->bind(
            'RentGorilla\Repositories\RewardRepository',
            'RentGorilla\Repositories\EloquentRewardRepository'
        );

        $this->app->bind(
            'RentGorilla\Repositories\VideoLikesRepository',
            'RentGorilla\Repositories\EloquentVideoLikesRepository'
        );

        $this->app->bind(
            'RentGorilla\Repositories\LocationRepository',
            'RentGorilla\Repositories\EloquentLocationRepository'
        );

        $this->app->bind(
            'RentGorilla\Repositories\FeaturesRepository',
            'RentGorilla\Repositories\EloquentFeaturesRepository'
        );

        $this->app->bind(
            'RentGorilla\Repositories\ServicesRepository',
            'RentGorilla\Repositories\EloquentServicesRepository'
        );

        $this->app->bind(
            'RentGorilla\Repositories\SafetiesRepository',
            'RentGorilla\Repositories\EloquentSafetiesRepository'
        );

        $this->app->bind(
            'RentGorilla\Repositories\HeatsRepository',
            'RentGorilla\Repositories\EloquentHeatsRepository'
        );

        $this->app->bind(
            'RentGorilla\Repositories\AppliancesRepository',
            'RentGorilla\Repositories\EloquentAppliancesRepository'
        );

        $this->app->bind(
            'RentGorilla\Repositories\AreasRepository',
            'RentGorilla\Repositories\EloquentAreasRepository'
        );
	}

}
