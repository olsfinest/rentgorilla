<?php namespace RentGorilla\Repositories;

use RentGorilla\Like;

class EloquentLikeRepository implements LikeRepository {

    public function toggle($user_id, $rental_id, $photo_id)
    {
        $like = Like::where(['user_id' => $user_id, 'rental_id' => $rental_id, 'photo_id' => $photo_id])->first();

        if( ! $like) {

            Like::create(compact('user_id', 'rental_id', 'photo_id'));

            return true;

        } else {

            $like->delete();

            return false;
        }
    }
}