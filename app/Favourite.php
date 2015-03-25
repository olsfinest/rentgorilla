<?php namespace RentGorilla;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model {

	protected $fillable = ['user_id', 'rental_id'];

	public function user()
	{
		return $this->belongsTo('RentGorilla\User');
	}

	public function rental()
	{
		return $this->belongsTo('RentGorilla\Rental');
	}
}
