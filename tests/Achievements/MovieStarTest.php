<?php

use Laracasts\TestDummy\DbTestCase;
use Laracasts\TestDummy\Factory;
use RentGorilla\Reward;
use RentGorilla\Rewards\Achievement;
use RentGorilla\Rewards\PowerPromoter;
use RentGorilla\User;

class MovieStarTest  extends DbTestCase {


    public function testCheckEligibility()
    {

/*
        $pp = App::make('RentGorilla\Rewards\MovieStar');

        $user = Factory::create('RentGorilla\User');

        dd($pp->checkEligibility());

        $user = User::where('id', $user->id);

        $this->assertEquals(10000, $user->points);

*/

    }

}