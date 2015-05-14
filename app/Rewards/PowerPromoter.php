<?php namespace RentGorilla\Rewards;

use DB;
use RentGorilla\Repositories\UserRepository;
use RentGorilla\User;

class PowerPromoter extends Achievement {

    const MIN_PROMOTIONS = 3;

    public function checkEligibility()
    {

        $hasMinPromotions = DB::table('promotions')
            ->select('user_id')
            ->groupBy('user_id')
            ->havingRaw('COUNT(user_id) >= ' . self::MIN_PROMOTIONS)
            ->lists('user_id');

        if(count($hasMinPromotions)) {

            $this->checkAlreadyRewarded($hasMinPromotions);

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
        return 'Power Promoter';
    }

    public function getPoints()
    {
        return 1000;
    }

    public function getClassName()
    {
        return Achievement::POWER_PROMOTER;
    }
}