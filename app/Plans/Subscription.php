<?php namespace RentGorilla\Plans;

use Illuminate\Support\Facades\Facade;

class Subscription extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'subscription';
    }
}