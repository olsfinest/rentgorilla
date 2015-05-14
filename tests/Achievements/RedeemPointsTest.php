<?php

use Laracasts\TestDummy\DbTestCase;
use Laracasts\TestDummy\Factory;
use RentGorilla\User;

class RedeemPointsTest extends DbTestCase {

    public function testRedeemPoints(){

        /*
         * A user may only redeem points in 10,000 point increments
         */

        $repo = app()->make('RentGorilla\Repositories\EloquentUserRepository');

        $user = Factory::create('RentGorilla\User', ['first_name' => 'Homer', 'points' => 15000]);

        $repo->redeemPoints($user);

        $user = User::where('first_name', 'Homer')->first();

        $this->assertEquals(5000, $user->points);

        //try to redeem < 10,000 points

        $repo->redeemPoints($user);

        $user = User::where('first_name', 'Homer')->first();

        $this->assertEquals(5000, $user->points);

    }

}