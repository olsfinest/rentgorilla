<?php

use Laracasts\TestDummy\DbTestCase;
use Laracasts\TestDummy\Factory;

class FavouritesControllerTest extends DbTestCase
{

    public function testToggleFavourite()
    {
        $user = Factory::create('RentGorilla\User');

        Auth::loginUsingId($user->id);

        $rental = Factory::create('RentGorilla\Rental');

        $post = ['user_id' => $user->id, 'rental_id' => $rental->id];

        $response = $this->call('post', '/favourite', $post);

        $data = $response->getData();

        $this->assertTrue($data->favourite);

        $response = $this->call('post', '/favourite', $post);

        $data = $response->getData();

        $this->assertFalse($data->favourite);
    }

    public function testShowFavourites()
    {
        $user = Factory::create('RentGorilla\User');

        Auth::loginUsingId($user->id);

        $this->route('get', 'favourites');
        $this->assertResponseOk();
    }


    public function testRemoveFavourite()
    {
        $user = Factory::create('RentGorilla\User');

        $rental = Factory::create('RentGorilla\Rental');

        Auth::loginUsingId($user->id);

        $this->assertCount(0, Auth::user()->favourites()->get());

        Auth::user()->favourites()->attach($rental->id);

        $this->assertCount(1, Auth::user()->favourites()->get());

        $this->route('DELETE', 'favourites.delete', [$rental->id]);

        $this->assertCount(0, Auth::user()->favourites()->get());

    }

}