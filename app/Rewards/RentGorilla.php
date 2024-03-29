<?php namespace RentGorilla\Rewards;

use Carbon\Carbon;
use DB;

class RentGorilla extends Achievement {

    const POINTS = 10000;
    const RECURRING_MONTHLY = false;

    public function checkEligibility()
    {
        $activeForOneYear = DB::table('rentals')
            ->select('user_id')
            ->whereNotNull('activated_at')
            ->where('activated_at', '<', Carbon::now()->subYear())
            ->lists('user_id');

        if(count($activeForOneYear)) {

           $this->checkAlreadyRewarded($activeForOneYear);
        }
    }

    public function getClassName()
    {
        return Achievement::RENT_GORILLA;
    }
}