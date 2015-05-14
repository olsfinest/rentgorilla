<?php namespace RentGorilla;

use Illuminate\Database\Eloquent\Model;

class Like extends Model {

    public $timestamps = false;

    protected $fillable = ['user_id', 'rental_id', 'photo_id'];
}