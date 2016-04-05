<?php namespace RentGorilla;

use Carbon\Carbon;
use Laravel\Cashier\Billable;
use Laravel\Cashier\Contracts\Billable as BillableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
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
        return Carbon::today()->subYear()->lt($this->created_at);
    }

    public function getFreePlanExpiryDate()
    {
        return $this->created_at->addYear();
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

    public function getPlanLink($plan_id)
    {

        $isCurrentPlan = $this->isCurrentPlan($plan_id);

        $plan = Subscription::plan($plan_id);

        $isMonthly = $plan->isMonthly();

        if ($this->stripeIsActive()) {
            if ($isCurrentPlan) {
                return $this->getLink('CANCEL', $plan_id, $isMonthly);
            }
        }

        if($isCurrentPlan && $this->cancelled() && $this->onGracePeriod()) {
            return $this->getLink('RESUME', $plan_id, $isMonthly);
        }

        if ( ! $this->stripeIsActive() && ! $this->onGracePeriod()) {
            return $this->getLink('SIGN UP', $plan_id, $isMonthly);
        } else {
            return $this->getLink('SWAP', $plan_id, $isMonthly);
        }

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

    public function isOnFreePlan()
    {

        return $this->joinedLessThanOneYearAgo() && ! $this->subscribed();

    }

    public function isCurrentPlan($plan_id)
    {
        return $plan_id === $this->getStripePlan();
    }

    public function isOnActivePlans($plans)
    {
        return $this->subscribed() && ($this->isCurrentPlan($plans[0]) || $this->isCurrentPlan($plans[1]));
    }

    public function getLink($action, $plan_id, $isMonthly)
    {

        switch ($action) {
            case 'CANCEL':
                if($isMonthly) {
                    return sprintf('<a class="monthly cancel" href="%s">%s</a>', route('cancelSubscription'), $action);
                } else {
                    return sprintf('<a class="yearly cancel" href="%s">%s</a>', route('cancelSubscription'), $action);
                }
            break;
            case 'SWAP':
                if($isMonthly) {
                    return sprintf('<a class="monthly" href="%s">%s</a>', route('swapSubscription', $plan_id), $action);
                } else {
                    return sprintf('<a class="yearly" href="%s">%s</a>', route('swapSubscription', $plan_id), $action);
                }
                break;
            case 'RESUME':
                if($isMonthly) {
                    return sprintf('<a class="monthly" href="%s">%s</a>', route('resumeSubscription'), $action);
                } else {
                    return sprintf('<a class="yearly" href="%s">%s</a>', route('resumeSubscription'), $action);
                }
                break;
            case 'SIGN UP':
                if($isMonthly) {
                    return sprintf('<a class="monthly" href="%s">%s</a>', route('showSubscribe', $plan_id), $action);
                } else {
                    return sprintf('<a class="yearly" href="%s">%s</a>', route('showSubscribe', $plan_id), $action);
                }
                break;

        }
    }

    //caches Stripe's subscription current period end locally
    public function getCurrentPeriodEnd() {

        if($this->stripeIsActive() && ( is_null($this->current_period_end) || Carbon::now()->gt($this->current_period_end))) {
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

        if ($this->onTrial() || ($rentalRepository->getActiveRentalCountForUser($this) === 0 && $this->joinedLessThanOneYearAgo())) {
            return true;
        } else if (($this->stripeIsActive() || $this->onGracePeriod()) && (Subscription::plan($this->getStripePlan())->unlimited() || $rentalRepository->getActiveRentalCountForUser($this) < Subscription::plan($this->getStripePlan())->maximumListings())) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteProfilePhotos()
    {
        if($this->profile) {
            $this->profile->deletePhotos();
        }
    }
}
