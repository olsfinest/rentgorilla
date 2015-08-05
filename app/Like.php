<?php namespace RentGorilla;

use Illuminate\Database\Eloquent\Model;

class Like extends Model {

    public $timestamps = true;

    protected $fillable = ['user_id', 'rental_id', 'photo_id'];
}