<?php

use Laracasts\TestDummy\DbTestCase;
use Laracasts\TestDummy\Factory;
use RentGorilla\Reward;
use RentGorilla\Rewards\Achievement;
use RentGorilla\User;

class LotsOfPhotosTest  extends DbTestCase {


    public function testCheckEligibility()
    {
/*
        $lop = App::make('RentGorilla\Rewards\LotsOfPhotos');

        $user = Factory::create('RentGorilla\User');

        $rental1 = Factory::create('RentGorilla\Rental', ['user_id' => $user->id]);

        $rental2 = Factory::create('RentGorilla\Rental', ['user_id' => $user->id]);

        Factory::times(5)->create('RentGorilla\Photo', ['user_id' => $user->id, 'rental_id' => $rental1->id]);

        Factory::times(5)->create('RentGorilla\Photo', ['user_id' => $user->id, 'rental_id' => $rental2->id]);

        Reward::create(['user_id' => 1, 'type' => Achievement::LOTS_OF_PHOTOS]);

        dd($lop->checkEligibility());


        $user = User::where('id', $user->id);

        $this->assertEquals(1000, $user->points);

*/
    }

}