<?php namespace RentGorilla\Repositories;

use RentGorilla\Reward;
use RentGorilla\User;

class EloquentRewardRepository implements RewardRepository {

    public function getRewardsForUser(User $user)
    {
        return Reward::where('user_id', $user->id)->lists('type')->all();
    }
}