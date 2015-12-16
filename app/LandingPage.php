<?php

namespace RentGorilla;

use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    public $guarded = ['id'];

    public function location()
    {
        return $this->hasOne('RentGorilla\Location');
    }

    public function slides()
    {
        return $this->hasMany('RentGorilla\Slide')->orderBy('order', 'DESC');
    }

    public function links()
    {
        return $this->hasMany('RentGorilla\Link');
    }
}
