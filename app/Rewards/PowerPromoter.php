<?php namespace RentGorilla\Rewards;

use DB;

class PowerPromoter extends Achievement {

    const MIN_PROMOTIONS = 2;
    const MIN_DAYS = 30;

    public function checkEligibility()
    {

        $hasMinPromotions = DB::table('promotions')
            ->select('user_id')
            ->whereRaw('DATEDIFF(NOW(), created_at) <= ' . self::MIN_DAYS)
            ->groupBy('user_id')
            ->havingRaw('COUNT(user_id) >= ' . self::MIN_PROMOTIONS)
            ->lists('user_id');

        if(count($hasMinPromotions)) {

            $this->checkAlreadyRewarded($hasMinPromotions);

        }
    }

    public function getClassName()
    {
        return Achievement::POWER_PROMOTER;
    }
}