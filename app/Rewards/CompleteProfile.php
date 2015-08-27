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

    public function isMonthly()
    {
        return true;
    }

    public function getName()
    {
        return 'Complete Profile';
    }

    public function getPoints()
    {
        return 500;
    }

    public function getClassName()
    {
        return Achievement::COMPLETE_PROFILE;
    }

    public function getDescription()
    {
        // TODO: Implement getDescription() method.
    }
}