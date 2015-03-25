<?php namespace RentGorilla\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use RentGorilla\Handlers\Events\UserEventHandler;

class EventServiceProvider extends ServiceProvider {


	/**
	 * The event handler mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [];


    protected $subscribe = [
        UserEventHandler::class
    ];
}
