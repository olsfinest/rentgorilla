<?php

use Laracasts\TestDummy\DbTestCase;
use Laracasts\TestDummy\Factory;
use RentGorilla\Like;

class LikesControllerTest extends DbTestCase{



    public function testRelationships()
    {

        $rental = Factory::create('RentGorilla\Rental');

        Like::create(['user_id' => 1, 'rental_id' => $rental->id, 'photo_id' => 1]);
        Like::create(['user_id' => 1, 'rental_id' => $rental->id, 'photo_id' => 2]);

        $this->assertCount(2, $rental->likes);

    }

    public function testToggleLike()
    {

        $user = Factory::create('RentGorilla\User');

        Auth::loginUsingId($user->id);

        $rental = Factory::create('RentGorilla\Rental', ['user_id' => $user->id]);

        $post = ['user_id' => $user->id, 'rental_id' => $rental->uuid, 'photo_id' => 1];

        $this->assertCount(0, $rental->likes);


        $response = $this->call('post', '/like', $post);

        $this->assertCount(1, $rental->likes()->get());

        $response = $this->call('post', '/like', $post);

        $this->assertCount(0, $rental->likes()->get());

    }
}