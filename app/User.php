<?php namespace RentGorilla;

use Laravel\Cashier\Billable;
use Laravel\Cashier\Contracts\Billable as BillableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract, BillableContract {

	use Authenticatable, CanResetPassword, Billable;

    protected $cardUpFront = false;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password'];

    protected $dates = ['trial_ends_at', 'subscription_ends_at'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	public function photos()
	{
		return $this->hasMany('RentGorilla\Photo');
	}

	public function rentals()
	{
		return $this->hasMany('RentGorilla\Rental');
	}

    public function profile()
    {
        return $this->hasOne('RentGorilla\Profile');
    }

	public function favourites()
	{
		return $this->belongsToMany('RentGorilla\Rental', 'favourites')->withTimestamps();
	}

    public function getFullName() {
        return $this->first_name . ' ' . $this->last_name;
    }


}
