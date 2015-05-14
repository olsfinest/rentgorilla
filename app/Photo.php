<?php namespace RentGorilla;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model {

    const IMAGE_PATH = '/img/uploads/';

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
            }
        } else {
            if (file_exists(public_path() . self::IMAGE_PATH . $size . $this->name)) {
                return self::IMAGE_PATH . $size . $this->name;
            } else {
                return 'defaults';
            }
        }
    }

    public function deleteAllSizes()
    {
        $sizes = ['small', 'medium', 'large'];

        foreach($sizes as $size) {
            $file = public_path() . self::IMAGE_PATH . $size . $this->name;
            if(file_exists($file)) {
                unlink($file);
            }
        }
    }

}