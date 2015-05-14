<?php namespace RentGorilla\Repositories;

interface LikeRepository {

    public function toggle($user_id, $rental_id, $photo_id);

}