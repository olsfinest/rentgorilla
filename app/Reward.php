<?php namespace RentGorilla;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model {

	public $guarded = ['id'];

    protected $dates = ['awarded_at'];

}
