<?php namespace RentGorilla\Rewards;

use DB;
use Config;

class MovieStar extends Achievement {

    const MIN_LIKES = 20;


    public function getClassName()
    {
        return Achievement::MOVIE_STAR;
    }

    public function checkEligibility()
    {
        $usersWithMinLikes = DB::table('video_likes')
            ->join('rentals', 'video_likes.rental_id', '=', 'rentals.id')
            ->select('rentals.user_id')
            ->where('active', 1)
            ->groupBy('rental_id')
            ->havingRaw('COUNT(rental_id) >= ' . self::MIN_LIKES)
            ->lists('rentals.user_id');

        if(count($usersWithMinLikes)) {

            $this->checkAlreadyRewarded($usersWithMinLikes);

        }
    }
}