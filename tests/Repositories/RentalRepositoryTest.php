<?php

use Carbon\Carbon;
use Laracasts\TestDummy\DbTestCase;
use Laracasts\TestDummy\Factory;
use RentGorilla\Rental;

class RentalRepositoryTest extends DbTestCase {


    public function testDowngrade()
    {

        $user = Factory::create('RentGorilla\User');

        $rentals = Factory::times(10)->create('RentGorilla\Rental', ['user_id' => $user->id, 'active' => 1, 'edited_at' => Carbon::now()]);

        $repo = app()->make('RentGorilla\Repositories\RentalRepository');

        $repo->downgradePlanCapacityForUser($user, 5);

        $count = Rental::where(['user_id' => $user->id, 'active' => 1])->count();

        $this->assertEquals(5, $count);

    }
}