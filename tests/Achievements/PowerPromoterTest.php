<?php

use Laracasts\TestDummy\DbTestCase;
use Laracasts\TestDummy\Factory;
use RentGorilla\Reward;
use RentGorilla\Rewards\Achievement;
use RentGorilla\Rewards\PowerPromoter;

class PowerPromoterTest  extends DbTestCase {


    public function testCheckEligibility()
    {

/*
        $pp = App::make('RentGorilla\Rewards\PowerPromoter');

        $user = Factory::create('RentGorilla\User');

        Factory::times(3)->create('RentGorilla\Promotion', ['user_id' => $user->id]);

        $user = Factory::create('RentGorilla\User');

        Factory::times(3)->create('RentGorilla\Promotion', ['user_id' => $user->id]);

        $reward = Reward::create(['user_id' => $user->id, 'type' => Achievement::GREAT_PHOTOS]);
        $reward = Reward::create(['user_id' => $user->id, 'type' => Achievement::POWER_PROMOTER]);

        dd($pp->checkEligibility());
*/

    }

}