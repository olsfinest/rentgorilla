<?php namespace RentGorilla;

use Carbon\Carbon;
use Laravel\Cashier\Billable;
use Laravel\Cashier\Contracts\Billable as BillableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract, BillableContract {

    const POINTS_PER_DOLLAR = 1000;
    const POINT_REDEMPTION_THRESHOLD = 10000;

    use Authenticatable, CanResetPassword, Billable;

    public function getTaxPercent()
    {
        return 15.0;
    }

    public function getCurrency()
    {
        return 'cad';
    }

    public function getCurrencyLocale()
    {
        return 'en_CA';
    }

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

    public function likes()
    {
        return $this->hasMany('RentGorilla\Like');
    }

    public function rewards()
    {
        return $this->hasMany('RentGorilla\Reward')->lists('type');
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

    public function joinedLessThanOneYearAgo()
    {
        return Carbon::today()->subYear()->lt($this->created_at);
    }

    public function getPointsMonetaryValue()
    {
        return number_format($this->getPointsReadyToRedeem() / self::POINTS_PER_DOLLAR, 2);
    }

    public function getStripeDiscount()
    {
        return $this->getPointsMonetaryValue() * -100;
    }

    public function getPointsReadyToRedeem()
    {
        return floor($this->points / self::POINT_REDEMPTION_THRESHOLD) * self::POINT_REDEMPTION_THRESHOLD;
    }
}
