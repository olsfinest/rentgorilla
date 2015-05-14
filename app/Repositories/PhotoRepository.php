<?php namespace RentGorilla\Repositories;

use RentGorilla\Photo;
use RentGorilla\User;

interface PhotoRepository {

    public function findPhotoForUser(User $user, $id);
    public function delete(Photo $photo);

}