<?php namespace RentGorilla\Rewards;

use Carbon\Carbon;
use DB;

class CurrentListings extends Achievement {

    public function checkEligibility()
    {
        $usersWithCurrentListings = DB::table('rentals')
            ->select('user_id')
            ->groupBy('user_id')
            ->havingRaw("MIN(edited_at) > '" . Carbon::now()->subDays(30) . "'")
            ->where('active', 1)
            ->lists('user_id');

        if(count($usersWithCurrentListings)) {

            $this->checkAlreadyRewarded($usersWithCurrentListings);

        }
    }

    public function getDescription()
    {
        // TODO: Implement getDescription() method.
    }

    public function isMonthly()
    {
        return true;
    }

    public function getName()
    {
        return 'Current Listings';
    }

    public function getPoints()
    {
        return 1000;
    }

    public function getClassName()
    {
        return Achievement::CURRENT_LISTINGS;
    }
}