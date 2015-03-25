<?php namespace RentGorilla\Repositories;

use RentGorilla\User;

interface FavouritesRepository
{
    public function toggle($user_id, $rental_id);
    public function findFavouritesForUser(User $user);
    public function removeFavouriteForUser(User $user, $rental_id);

}