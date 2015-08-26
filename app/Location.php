<?php

namespace RentGorilla;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public $guarded = ['id'];

    public function rentals()
    {
        return $this->hasMany('RentGorilla\Rental');
    }
}
