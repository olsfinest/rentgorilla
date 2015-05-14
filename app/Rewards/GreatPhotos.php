<?php namespace RentGorilla\Rewards;

use DB;

class GreatPhotos extends Achievement {

    const MIN_LIKES = 20;

    public function checkEligibility()
    {
        $usersWithMinLikes = DB::table('likes')
            ->join('rentals', 'likes.rental_id', '=', 'rentals.id')
            ->select('rentals.user_id')
            ->where('active', 1)
            ->groupBy('rental_id')
            ->havingRaw('COUNT(rental_id) >= ' . self::MIN_LIKES)
            ->lists('rentals.user_id');

        if(count($usersWithMinLikes)) {

            $this->checkAlreadyRewarded($usersWithMinLikes);

        }
    }

    public function getDescription()
    {
        // TODO: Implement getDescription() method.
    }

    public function isMonthly()
    {
        return false;
    }

    public function getName()
    {
        return 'Great Photos';
    }

    public function getPoints()
    {
        return 5000;
    }

    public function getClassName()
    {
        return Achievement::GREAT_PHOTOS;
    }
}