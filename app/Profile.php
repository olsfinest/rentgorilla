<?php namespace RentGorilla;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    public $timestamps = true;

    const PHOTO_PATH = '/img/profiles/';
    const PHOTO_SIDE = 40;

    public function user()
    {
        return $this->belongsTo('RentGorilla\User');
    }

    public function getPhoto()
    {
        if(is_null($this->photo))
        {
            return false;
        } else {
            return self::PHOTO_PATH . $this->photo;
        }
    }

    public function deletePhoto()
    {
        if(is_null($this->photo)){
            return false;
        } else {
            return unlink(public_path() . self::PHOTO_PATH . $this->photo);
        }
    }
}
