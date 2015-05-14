<?php

use Laracasts\TestDummy\DbTestCase;
use Laracasts\TestDummy\Factory;
use RentGorilla\Reward;
use RentGorilla\Rewards\Achievement;

class GreatPhotosTest  extends DbTestCase {


    public function testCheckEligibility()
    {
/*
        $gp = App::make('RentGorilla\Rewards\GreatPhotos');

        $user = Factory::create('RentGorilla\User');

        $rental = Factory::create('RentGorilla\Rental', ['user_id' => $user->id]);

        Factory::times(20)->create('RentGorilla\Like', ['user_id' => $user->id, 'rental_id' => $rental->id, 'photo_id' => 1]);

        $user = Factory::create('RentGorilla\User');

        $rental = Factory::create('RentGorilla\Rental', ['user_id' => $user->id]);

        Factory::times(20)->create('RentGorilla\Like', ['user_id' => $user->id, 'rental_id' => $rental->id, 'photo_id' => 1]);

        //Reward::create(['user_id' => 1, 'type' => Achievement::GREAT_PHOTOS]);

        dd($gp->checkEligibility());
        */
    }

}