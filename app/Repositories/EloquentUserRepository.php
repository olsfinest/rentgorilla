<?php namespace RentGorilla\Repositories;

use Illuminate\Support\Facades\DB;
use RentGorilla\User;

class EloquentUserRepository implements UserRepository
{

    /**
     * Find a user by id
     *
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return User::findOrFail($id);
    }


    /**
     * Gets an array of rental ids that a given User has favourited
     *
     * @param $user \RentGorilla\User
     * @return array
     */
    public function getFavouriteRentalIdsForUser(User $user)
    {
        return $user->favourites->lists('id');
    }

    /**
     * Saves the model
     *
     * @param User $user
     * @return bool
     */
    public function save(User $user)
    {
        return $user->save();
    }

    /**
     * Gets a user by a column attribute
     *
     * @param $attribute
     * @param $searchTerm
     * @return mixed
     */
    public function getUserByAttribute($attribute, $searchTerm)
    {
        return User::where($attribute, $searchTerm)->firstOrFail();
    }

    /**
     * Confirms a user
     *
     * @param User $user
     * @return User
     */
    public function confirm(User $user)
    {
        $user->confirmed = 1;

        $user->save();

        return $user;
    }

    public function getPhotoLikesForUser(User $user)
    {
        return $user->likes->lists('photo_id');
    }

    public function awardPoints(User $user, $points)
    {
        $user->points = $user->points + $points;

        return $user->save();
    }

    public function redeemPoints(User $user)
    {
        $pointsToSubtract = $user->getPointsReadyToRedeem();

        if($pointsToSubtract) {
            $user->points = $user->points - $pointsToSubtract;
            return $user->save();
        } else {
            return false;
        }
    }
}