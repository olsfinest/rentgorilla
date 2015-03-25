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

    public function getNameAttribute($value)
    {
        return self::IMAGE_PATH . $value;
    }

}