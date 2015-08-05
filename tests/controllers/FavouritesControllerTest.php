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

        $post = ['user_id' => $user->id, 'rental_id' => $rental->uuid];

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


}