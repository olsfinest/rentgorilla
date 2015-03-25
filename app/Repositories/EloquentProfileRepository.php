<?php namespace RentGorilla\Repositories;

use RentGorilla\Profile;
use RentGorilla\User;

class EloquentProfileRepository implements ProfileRepository {

    public function save(Profile $profile)
    {
        return $profile->save();
    }

    public function getProfileForUser(User $user)
    {
        return is_null($user->profile) ? $user->profile()->create([]) : $user->profile;
    }
}