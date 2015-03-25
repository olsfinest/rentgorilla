<?php namespace RentGorilla\Repositories;

use RentGorilla\User;

interface UserRepository
{
    public function find($id);
    public function save(User $user);
    public function getFavouriteRentalIdsForUser($user_id);
    public function getUserByAttribute($attribute, $searchTerm);
    public function confirm(User $user);
}