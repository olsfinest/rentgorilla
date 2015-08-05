<?php

use Laracasts\TestDummy\DbTestCase;
use Laracasts\TestDummy\Factory;
use RentGorilla\Reward;
use RentGorilla\Rewards\Achievement;
use RentGorilla\User;

class CurrentListingsTest  extends DbTestCase {


    public function testCheckEligibility()
    {
/*
        $cl = App::make('RentGorilla\Rewards\CurrentListings');

        $user = Factory::create('RentGorilla\User');

        $rental = Factory::create('RentGorilla\Rental', ['updated_at' => \Carbon\Carbon::today()->subYear()]);

        $rental = Factory::create('RentGorilla\Rental', ['user_id' => $user->id, 'updated_at' => \Carbon\Carbon::now()->subDays(31)]);

        $rental = Factory::create('RentGorilla\Rental', ['user_id' => $user->id, 'updated_at' => \Carbon\Carbon::now()->addYear()]);

        dd($cl->checkEligibility());



        $user = User::where('id', $user->id);

        $this->assertEquals(1000, $user->points);

*/
    }

}