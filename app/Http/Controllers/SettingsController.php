<?php namespace RentGorilla\Http\Controllers;

use Auth;
use RentGorilla\Http\Requests\ModifyProfileRequest;


class SettingsController extends Controller {


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showProfile()
	{
        $profile = Auth::user()->profile;

		return view('settings.profile', compact('profile'));
	}

    public function updateProfile(ModifyProfileRequest $request)
    {
        $this->dispatchFrom('RentGorilla\Commands\ModifyProfileCommand', $request, [
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->back()->with('flash', 'Your profile has been updated!');
    }

	public function showChangePlan()
	{
		return view('settings.change-plan');
	}

	public function showApplyCoupon()
	{
		return view('settings.apply-coupon');
	}

	public function showPaymentHistory()
	{
		return view('settings.payment-history');
	}

	public function showUpdateCard()
	{
		return view('settings.update-card');
	}

	public function showCancelSubscription()
	{
		return view('settings.cancel-subscription');
	}
}
