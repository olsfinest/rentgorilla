<?php namespace RentGorilla;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rentals';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type', 'province', 'city', 'streetAddress', 'beds', 'price', 'available_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = ['available_at'];

    public function user()
    {
        return $this->belongsTo('RentGorilla\User');
    }

    public function photos()
    {
        return $this->hasMany('RentGorilla\Photo');
    }

    public function favouritedBy()
    {
        return $this->belongsToMany('RentGorilla\User', 'favourites')->withTimestamps();
    }

    public function getAddress()
    {
        return sprintf('%s, %s, %s', $this->street_address, $this->city, $this->province);
    }

    public function isActive()
    {
        return $this->active === 1;
    }
/*
    public function getAvailableAtAttribute($date) {
        return Carbon::parse($date)->format('M jS, Y');
    }




*/
}