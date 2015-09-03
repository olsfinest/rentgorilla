<?php namespace RentGorilla\Rewards;

use DB;

class CompleteProfile extends Achievement {


    public function checkEligibility()
    {
        $usersWithCompleteProfiles = DB::table('profiles')
            ->select('user_id')
            ->whereNotNull('primary_phone')
            ->whereNotNull('website')
            ->whereNotNull('bio')
            ->lists('user_id');

        if(count($usersWithCompleteProfiles)) {

            $this->checkAlreadyRewarded($usersWithCompleteProfiles);

        }
    }

    public function getClassName()
    {
        return Achievement::COMPLETE_PROFILE;
    }
    
}