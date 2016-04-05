<?php namespace RentGorilla;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    public $timestamps = true;

    const PHOTO_PATH = '/img/profiles/';
    const PHOTO_SIDE = 40;
    const PHOTO_LARGE_MAX_WIDTH = 300;

    public function user()
    {
        return $this->belongsTo('RentGorilla\User');
    }

    public function getSizes()
    {
        return ['small', 'large'];
    }

    public function getPhoto($size)
    {
        if(! in_array($size, $this->getSizes())) {
            return false;
        }

        if(is_null($this->photo)) {
            return false;
        }

        $path = self::PHOTO_PATH . $size . $this->photo;

        if (file_exists(public_path() . $path)) {
            return $path;
        }

        return false;
    }

    public function deletePhotos()
    {
        if (is_null($this->photo)) {
            return false;
        }

        foreach ($this->getSizes() as $size) {
            $file = public_path() . self::PHOTO_PATH . $size . $this->photo;
            if (file_exists($file)) {
                unlink($file);
            }
        }

        return true;
    }
}
