<?php namespace RentGorilla\Repositories;

use RentGorilla\User;

interface RewardRepository {

    public function getRewardsForUser(User $user);

}