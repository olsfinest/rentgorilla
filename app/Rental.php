<?php namespace RentGorilla;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model {

    const RESULTS_PER_PAGE = 12;

    protected $guarded = ['id'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rentals';


    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = ['available_at', 'promotion_ends_at', 'queued_at', 'activated_at', 'edited_at'];

    public function user()
    {
        return $this->belongsTo('RentGorilla\User');
    }

    public function pricePerSquareFoot()
    {
        return number_format($this->price / $this->square_footage, 2);
    }
    public function photos()
    {
        return $this->hasMany('RentGorilla\Photo');
    }

    public function favouritedBy()
    {
        return $this->belongsToMany('RentGorilla\User', 'favourites')->withTimestamps();
    }

    public function features()
    {
        return $this->belongsToMany('RentGorilla\Feature')->withTimestamps();
    }

    public function heat()
    {
        return $this->belongsToMany('RentGorilla\Heat')->withTimestamps();
    }

    public function appliances()
    {
        return $this->belongsToMany('RentGorilla\Appliance')->withTimestamps();
    }

    public function getAddress()
    {
        return sprintf('%s, %s, %s', $this->street_address, $this->city, $this->province);
    }

    public function getFeatureListAttribute()
    {
        return $this->features()->lists('id');
    }

    public function getApplianceListAttribute()
    {
        return $this->appliances()->lists('id');
    }

    public function getHeatListAttribute()
    {
        return $this->heat()->lists('id');
    }

    public function setAvailableAttribute($date)
    {
        $this->attributes['available_at'] = Carbon::createFromFormat('m/d/Y', $date)->format('Y-m-d 00:00:00');
    }

    public function isActive()
    {
        return $this->active === 1;
    }

    public function isPromoted()
    {
        return $this->promoted === 1;
    }

    public function getAvailableAttribute()
    {
        return $this->available_at ? $this->available_at->format('m/d/Y') : null;
    }

    /*
    public function getAvailableAtAttribute($date) {
        return Carbon::parse($date)->format('M jS, Y');
    }
    */


    public function likes()
    {
        return $this->hasMany('RentGorilla\Like');
    }

}