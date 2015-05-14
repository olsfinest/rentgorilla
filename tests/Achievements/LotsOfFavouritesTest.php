<?php

use Laracasts\TestDummy\DbTestCase;
use Laracasts\TestDummy\Factory;
use RentGorilla\Reward;
use RentGorilla\Rewards\Achievement;

class LotsOfFavouritesTest  extends DbTestCase {


    public function testCheckEligibility()
    {
/*
        $gp = App::make('RentGorilla\Rewards\LotsOfFavourites');

        $user = Factory::create('RentGorilla\User');

        $rental = Factory::create('RentGorilla\Rental', ['user_id' => $user->id]);

        Factory::times(20)->create('RentGorilla\Favourite', ['user_id' => $user->id, 'rental_id' => $rental->id]);

        $user = Factory::create('RentGorilla\User');

        $rental = Factory::create('RentGorilla\Rental', ['user_id' => $user->id]);

        Factory::times(20)->create('RentGorilla\Favourite', ['user_id' => $user->id, 'rental_id' => $rental->id]);

        Reward::create(['user_id' => 1, 'type' => Achievement::LOTS_OF_FAVOURITES]);

        dd($gp->checkEligibility());
*/
    }

}