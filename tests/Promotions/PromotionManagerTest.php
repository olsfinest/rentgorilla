<?php

use Carbon\Carbon;
use Laracasts\TestDummy\DbTestCase;
use Laracasts\TestDummy\Factory;
use RentGorilla\Promotions\PromotionManager;
use RentGorilla\Repositories\EloquentRentalRepository;

class PromotionManagerTest extends DbTestCase {

    public function testGetNextAvailablePromotionDate()
    {

    }


    /**
     *
     *
    public function testGetNextAvailablePromotionDate()
    {
        Factory::create('RentGorilla\Rental', ['promoted' => 1, 'promotion_ends_at' => Carbon::createFromDate(2015,1,1)]);
        Factory::create('RentGorilla\Rental', ['promoted' => 1, 'promotion_ends_at' => Carbon::createFromDate(2015,1,2)]);
        Factory::create('RentGorilla\Rental', ['promoted' => 1, 'promotion_ends_at' => Carbon::createFromDate(2015,1,3)]);

        Factory::times(9)->create('RentGorilla\Promotion');

        $rental = Factory::create('RentGorilla\Rental');

        $manager = new PromotionManager(new EloquentRentalRepository());

        dd($manager->getNextAvailablePromotionDate($rental));


    }
     *
     * */

}