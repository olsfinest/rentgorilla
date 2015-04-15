<?php namespace RentGorilla\Repositories;

use RentGorilla\Favourite;
use RentGorilla\User;

class EloquentFavouritesRepository implements FavouritesRepository
{

    public function toggle($user_id, $rental_id)
    {
        $favourite = Favourite::where(['user_id' => $user_id, 'rental_id' => $rental_id])->first();

        if( ! $favourite) {

            Favourite::create(compact('user_id', 'rental_id'));

            return true;

        } else {

            $favourite->delete();

            return false;
        }
    }

    public function findFavouritesForUser(User $user)
    {
        return $user->favourites;
    }

    public function removeFavouriteForUser(User $user, $rental_id)
    {
         $favourite = Favourite::where(['user_id' => $user->id, 'rental_id' => $rental_id])->firstOrFail();

        //alternative syntax: $user->favourites()->detach($rental_id);

        return $favourite->delete();
    }
}