<?php namespace RentGorilla\Repositories;

interface VideoLikesRepository {


    public function toggle($user_id, $rental_id);
    public function isLikedByUser($user_id, $rental_id);

}