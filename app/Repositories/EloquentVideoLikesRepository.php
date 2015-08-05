<?php namespace RentGorilla\Repositories;

use RentGorilla\User;
use RentGorilla\VideoLike;

class EloquentVideoLikesRepository implements VideoLikesRepository {

    public function toggle($user_id, $rental_id)
    {
        $like = VideoLike::where(['user_id' => $user_id, 'rental_id' => $rental_id])->first();

        if( ! $like) {

            VideoLike::create(compact('user_id', 'rental_id'));

            return true;

        } else {

            $like->delete();

            return false;
        }
    }


    public function isLikedByUser($user_id, $rental_id)
    {
        $like = VideoLike::where(['user_id' => $user_id, 'rental_id' => $rental_id])->first();

        if($like) {
            return true;
        } else {
            return false;
        }
    }
}