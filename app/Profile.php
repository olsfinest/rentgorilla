<?php namespace RentGorilla;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public function user()
    {
        return $this->belongsTo('RentGorilla\User');
    }
}
