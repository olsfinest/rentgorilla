<?php namespace RentGorilla\Rewards;

use DB;

class LotsOfFavourites extends Achievement {

    const MIN_FAVOURITES = 20;

    public function checkEligibility()
    {
        $usersWithMinFavourites = DB::table('favourites')
            ->join('rentals', 'favourites.rental_id', '=', 'rentals.id')
            ->select('rentals.user_id')
            ->where('active', 1)
            ->groupBy('rental_id')
            ->havingRaw('COUNT(rental_id) >= ' . self::MIN_FAVOURITES)
            ->lists('rentals.user_id');

        if(count($usersWithMinFavourites)) {

            $this->checkAlreadyRewarded($usersWithMinFavourites);

        }
    }

    public function getClassName()
    {
        return Achievement::LOTS_OF_FAVOURITES;
    }
}