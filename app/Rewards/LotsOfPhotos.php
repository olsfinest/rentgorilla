<?php namespace RentGorilla\Rewards;

use DB;

class LotsOfPhotos extends Achievement {

    const MIN_RENTALS = 2;
    const MIN_PHOTOS = 10;

    public function checkEligibility()
    {
        $usersWithMinRentals = DB::table('rentals')
            ->select('user_id')
            ->groupBy('user_id')
            ->havingRaw('COUNT(user_id) >= ' . self::MIN_RENTALS)
            ->where('active', 1)
            ->lists('user_id');

        if (count($usersWithMinRentals)) {

            $usersWithMinPhotos = DB::table('photos')
                ->select('user_id')
                ->whereIn('user_id', $usersWithMinRentals)
                ->groupBy('user_id')
                ->havingRaw('COUNT(user_id) >= ' . self::MIN_PHOTOS)
                ->lists('user_id');

            if (count($usersWithMinPhotos)) {

                $this->checkAlreadyRewarded($usersWithMinPhotos);
            }
        }
    }

    public function getClassName()
    {
        return Achievement::LOTS_OF_PHOTOS;
    }
}