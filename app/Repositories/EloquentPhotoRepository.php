<?php namespace RentGorilla\Repositories;

use RentGorilla\Photo;
use RentGorilla\User;

class EloquentPhotoRepository implements PhotoRepository {

    public function findPhotoForUser(User $user, $filename)
    {
        return Photo::where(['user_id' => $user->id, 'name' => $filename])->firstOrFail();
    }

    public function delete(Photo $photo)
    {
        return $photo->delete();
    }
}