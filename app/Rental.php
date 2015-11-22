<?php namespace RentGorilla;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use RentGorilla\Promotions\PromotionManager;

class Rental extends Model {

    public $timestamps = true;

    const RESULTS_PER_PAGE = 12;

    const HOUSE = 'house';
    const APARTMENT = 'apartment';
    const ROOM = 'room';
    const COMMERCIAL = 'commercial';

    protected $with = ['location'];

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


    public function location()
    {
        return $this->belongsTo('RentGorilla\Location');
    }

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
        return $this->hasMany('RentGorilla\Photo')->orderBy('order', 'DESC');
    }

    public function favouritedBy()
    {
        return $this->belongsToMany('RentGorilla\User', 'favourites')->withTimestamps();
    }

    public function videoLikedBy()
    {
        return $this->belongsToMany('RentGorilla\User', 'video_likes')->withTimestamps();
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
        return sprintf('%s, %s, %s', $this->street_address, $this->location->city, $this->location->province);
    }

    public function getFeatureListAttribute()
    {
        return $this->features()->lists('id')->all();
    }

    public function getApplianceListAttribute()
    {
        return $this->appliances()->lists('id')->all();
    }

    public function getHeatListAttribute()
    {
        return $this->heat()->lists('id')->all();
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

    public function isQueued()
    {
        return $this->queued === 1;
    }

    public function getProvinceAttribute()
    {
        return is_null($this->location) ? null : $this->location->province;
    }

    public function getPromotedDaysRemaining()
    {
        return $this->promotion_ends_at->diff(Carbon::now())->format('%d days, %h hours');
    }

    public function getAvailableAttribute()
    {
        return $this->available_at ? $this->available_at->format('m/d/Y') : null;
    }

    public function getCityOnlyAttribute()
    {
        if(is_null($this->location)) {
            return null;
        } else {
            $cityAndCounty = explode(', ', $this->location->city);
            return reset($cityAndCounty);
        }
    }

    public function likes()
    {
        return $this->hasMany('RentGorilla\Like');
    }

    public function getNextAvailablePromotionDays()
    {
        $promotionManager = app()->make('RentGorilla\Promotions\PromotionManager');

        $nextAvailableDate = $promotionManager->getNextAvailablePromotionDate($this);

        if($nextAvailableDate === false) {
            return 0;
        } else {
            return $nextAvailableDate['daysRemaining'];
        }
    }

    public function isNotFreePromotion()
    {
        return $this->free_promotion === 0;
    }

}