<?php namespace RentGorilla\Plans;

use Illuminate\Support\Facades\Facade;

class SubscriptionPlan extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'subscription';
    }
}