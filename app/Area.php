<?php

namespace RentGorilla;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    public $guarded = [];

    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    public function canDelete()
    {
        return $this->locations()->count() === 0;
    }

    public function nameAndProvince()
    {
        return $this->name . ', ' . $this->province;
    }
}
