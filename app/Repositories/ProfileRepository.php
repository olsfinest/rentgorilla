<?php namespace RentGorilla\Repositories;

use RentGorilla\Profile;
use RentGorilla\User;

interface ProfileRepository {

    public function save(Profile $profile);
    public function getProfileForUser(User $user);

}