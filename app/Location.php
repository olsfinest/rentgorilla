<?php

namespace RentGorilla;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public $guarded = ['id'];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function rentals()
    {
        return $this->hasMany('RentGorilla\Rental');
    }

    public function rentalsCount()
    {
        return $this->hasOne('RentGorilla\Rental')
            ->where('active', 1)
            ->selectRaw('location_id, count(*) as aggregate')
            ->groupBy('location_id');
    }

    public function getRentalsCountAttribute()
    {
        // if relation is not loaded already, let's do it first
        if ( ! array_key_exists('rentalsCount', $this->relations))
            $this->load('rentalsCount');

        $related = $this->getRelation('rentalsCount');

        // then return the count directly
        return ($related) ? (int) $related->aggregate : 0;
    }

    public function queuedRentals()
    {
        return $this->rentals()->where(['queued' => 1])->orderBy('queued_at');
    }

    public function promotedRentals()
    {
        return $this->rentals()->where(['promoted' => 1])->orderBy('promotion_ends_at');
    }

    public function landingPage()
    {
        return $this->belongsTo('RentGorilla\LandingPage');
    }

    public function monthlySearches()
    {
        return $this->hasMany('RentGorilla\MonthlySearches');
    }

    public function cityAndProvince()
    {
        return sprintf('%s, %s', $this->city, $this->province);
    }

    public function averagePrice($rentalType)
    {
       $price = $this->rentals()->where('type', $rentalType)->avg('price');

        if($price) {
            return number_format($price, 2);
        } else {
            return null;
        }
    }

    public function getMonthlySearches()
    {

        $searchCount = $this->monthlySearches()->where(['month' => date('m'), 'year' => date('Y')])->get()->first();

        if($searchCount) {
            return $searchCount->searches;
        } else {
            return null;
        }
    }

}
