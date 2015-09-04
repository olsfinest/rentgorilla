<?php

use Carbon\Carbon;
use Laracasts\TestDummy\DbTestCase;
use Laracasts\TestDummy\Factory;
use RentGorilla\Promotions\PromotionManager;
use RentGorilla\Repositories\EloquentRentalRepository;

class PromotionManagerTest extends DbTestCase {


    public function testGetNextAvailablePromotionDate()
    {
        Factory::create('RentGorilla\Rental', ['location_id' => 1, 'promoted' => 1, 'promotion_ends_at' => Carbon::createFromDate(2015,1,1)]);
        Factory::create('RentGorilla\Rental', ['location_id' => 1, 'promoted' => 1, 'promotion_ends_at' => Carbon::createFromDate(2015,1,2)]);
        Factory::create('RentGorilla\Rental', ['location_id' => 1, 'promoted' => 1, 'promotion_ends_at' => Carbon::createFromDate(2015,1,3)]);

        Factory::times(4)->create('RentGorilla\Rental', ['location_id' => 1, 'queued' => 1]);

        $rental = Factory::create('RentGorilla\Rental');

        $manager = app()->make('RentGorilla\Promotions\PromotionManager');

        dd($manager->getNextAvailablePromotionDate($rental));

    }

}