<?php namespace RentGorilla\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use RentGorilla\Events\RentalViewed;
use RentGorilla\Events\SearchWasInitiated;
use RentGorilla\Handlers\Events\RentalViewedEventHandler;
use RentGorilla\Handlers\Events\UpdateSearchCounts;
use RentGorilla\Handlers\Events\UserEventHandler;
use Event;

class EventServiceProvider extends ServiceProvider {


	/**
	 * The event handler mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
        RentalViewed::class => [ RentalViewedEventHandler::class ],
        SearchWasInitiated::class => [ UpdateSearchCounts::class ]
        ];


    protected $subscribe = [
        UserEventHandler::class
    ];

}
