<?php namespace RentGorilla\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use RentGorilla\Events\RentalViewed;
use RentGorilla\Handlers\Events\RentalViewedEventHandler;
use RentGorilla\Handlers\Events\UserEventHandler;

class EventServiceProvider extends ServiceProvider {


	/**
	 * The event handler mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
        RentalViewed::class => [
            RentalViewedEventHandler::class]
        ];


    protected $subscribe = [
        UserEventHandler::class
    ];
}
