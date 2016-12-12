<?php namespace RentGorilla;

use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Laravel\Cashier\Contracts\Billable as BillableContract;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Laravel\Cashier\Billable;
use Carbon\Carbon;
use Subscription;

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

    protected $dates = ['trial_ends_at', 'subscription_ends_at', 'current_period_end'];

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
        return $this->hasMany('RentGorilla\Reward')->lists('type')->all();
    }

    public function profile()
    {
        return $this->hasOne('RentGorilla\Profile');
    }

    public function getProfileItem($item)
    {
        if ( ! $this->relationLoaded('profile')) {
            $this->load('profile');
        }

        $profile = $this->getRelation('profile');

        if( is_null($profile)) return null;

        return $profile->{$item};
    }

    public function getProfilePhoto($size)
    {
        if ( ! $this->relationLoaded('profile')) {
            $this->load('profile');
        }

        $profile = $this->getRelation('profile');

        if( is_null($profile)) return null;

        return $profile->getPhoto($size);
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
        return Carbon::now()->subYear()->lt($this->created_at);
    }

    public function joinedLessThanXDaysAgo()
    {
        return Carbon::now()->subDays(config('plans.freeForXDays'))->lt($this->created_at);
    }

    public function getFreePlanExpiryDate()
    {
        if($this->isGrandfathered()) {
            return $this->created_at->addYear();
        }

        return $this->created_at->addDays(config('plans.freeForXDays'));
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

    public function isAdmin()
    {
        return $this->is_admin === 1;
    }

    public function isSuper()
    {
        return $this->is_super === 1;
    }

    public function isUnconfirmed()
    {
        return $this->confirmed === 0;
    }

    public function isGrandfathered()
    {
        return $this->is_grandfathered === 1;
    }

    public function isOnFreePlan()
    {
        return $this->isEligibleForFreePlan() && ! $this->subscribed();
    }

    public function isEligibleForFreePlan()
    {
        if($this->isGrandfathered()) {
            return $this->joinedLessThanOneYearAgo();
        }

        return $this->joinedLessThanXDaysAgo();
    }

    public function isCurrentPlan($plan_id)
    {
        return $plan_id === $this->getStripePlan();
    }

    public function isOnActivePlans($plans)
    {
        return $this->subscribed() && ($this->isCurrentPlan($plans[0]) || $this->isCurrentPlan($plans[1]));
    }

    //caches Stripe's subscription current period end locally
    public function getCurrentPeriodEnd()
    {
        //cancelled
        if(! is_null($this->getSubscriptionEndDate())) {
            return $this->getSubscriptionEndDate();
        }

        //active
        if($this->stripeIsActive() && ( is_null($this->current_period_end) || (! is_null($this->current_period_end) && Carbon::now()->gt($this->current_period_end))))  {
            $currentPeriodEnd = $this->subscription()->getSubscriptionEndDate();
            $this->current_period_end = $currentPeriodEnd;
            $this->save();
            return $currentPeriodEnd;
        }

        return $this->current_period_end;
    }

    public function canActivateRental()
    {
        $rentalRepository = app()->make('RentGorilla\Repositories\RentalRepository');

        $activeRentalCountForUser = $rentalRepository->getActiveRentalCountForUser($this);

        // members on trial can activate unlimited properties
        if ($this->onTrial()) {
            return true;
        }

        // only eligible for one property on free plan
        if ($activeRentalCountForUser === 0 && $this->isEligibleForFreePlan()) {
            return true;
        }

        // activate properties up to the plan's capacity for active subscribers
        if ($this->subscribed() && ($this->plan()->unlimited() || $activeRentalCountForUser < $this->plan()->maximumListings())) {
            return true;
        }

        return false;
    }

    public function deleteProfilePhotos()
    {
        if($this->profile) {
            $this->profile->deletePhotos();
        }
    }

    public function plan()
    {
        return Subscription::plan($this->getStripePlan());
    }
}
