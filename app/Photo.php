<?php namespace RentGorilla;

use Illuminate\Database\Eloquent\Model;

use File;

class Photo extends Model {

    public $timestamps = true;

    const IMAGE_PATH = '/img/uploads/';

    const SMALL_WIDTH = 237;
    const SMALL_HEIGHT = 158;
    const MEDIUM_WIDTH = 625;
    const MEDIUM_HEIGHT = 468;
    const LARGE_WIDTH = 1000;
    const LARGE_HEIGHT = 750;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'photos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo('RentGorilla\User');
    }

    public function rental()
    {
        return $this->belongsTo('RentGorilla\Rental');
    }

    //TODO: Strip out local stuff for production?
    public function getSize($size)
    {
        if(app()->environment() == 'local') {
            if($size == 'small' && file_exists( public_path() . self::IMAGE_PATH . 'placeholders/' . $this->name)) {
                return self::IMAGE_PATH . 'placeholders/' . $this->name;
            } else if( $size == 'medium' && file_exists( public_path() . self::IMAGE_PATH . 'placeholders/mine/' . $this->name)) {
                return self::IMAGE_PATH . 'placeholders/mine/' . $this->name;
            } elseif(file_exists(public_path() . self::IMAGE_PATH . $size . $this->name)) {
                return self::IMAGE_PATH . $size . $this->name . '?' . filemtime($this->getPublicPath($size));
            }
        } else {
            if (file_exists(public_path() . self::IMAGE_PATH . $size . $this->name)) {
                return self::IMAGE_PATH . $size . $this->name . '?' . filemtime($this->getPublicPath($size));
            } else {
                return 'defaults';
            }
        }
    }

    public function deleteAllSizes()
    {
        $sizes = ['small', 'medium', 'large'];

        foreach($sizes as $size) {
            $file = $this->getPublicPath($size);
            if(file_exists($file)) {
                unlink($file);
            }
        }
    }

    public function getPublicPath($size)
    {
        return public_path() . self::IMAGE_PATH . $size . $this->name;
    }

    public static function getNoPhotos($size)
    {
        $dirListing = File::files(public_path() . "/img/gorillas/{$size}");

        if(empty($dirListing)) return collect([]);

        $files = array_map(function($item){
            return str_replace(public_path(), '', $item);
        }, $dirListing);

        return collect($files);
    }

}