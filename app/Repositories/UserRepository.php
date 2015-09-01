<?php namespace RentGorilla\Repositories;

use RentGorilla\User;

interface UserRepository
{
    public function find($id);
    public function save(User $user);
    public function getFavouriteRentalIdsForUser(User $user);
    public function getUserByAttribute($attribute, $searchTerm);
    public function confirm(User $user);
    public function getPhotoLikesForUser(User $user);
    public function awardPoints(User $user, $points);
    public function redeemPoints(User $user);
    public function emailSearch($email);
    public function getPaginated(array $params);
    public function delete($id);
}