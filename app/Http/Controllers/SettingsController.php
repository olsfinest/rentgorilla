<?php namespace RentGorilla\Http\Controllers;

use Auth;
use RentGorilla\Billing\StripeBiller;
use RentGorilla\Http\Requests\ModifyProfileRequest;
use RentGorilla\Plans\Subscription;


class SettingsController extends Controller {


    /**
     * @var StripeBiller
     */
    protected $biller;

    public function __construct(StripeBiller $biller)
    {
        $this->middleware('auth');
        $this->biller = $biller;
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

        return redirect()->back()->with('flash_message', 'Your profile has been updated!');
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

        $charges = Auth::user()->readyForBilling() ? $this->biller->getCharges(Auth::user()->getStripeId()) : null;

        $upcomingInvoice = Auth::user()->readyForBilling() ? Auth::user()->subscription()->upcomingInvoice() : null;

        $invoices = Auth::user()->readyForBilling() ? Auth::user()->invoices() : null;

		return view('settings.payment-history', compact('upcomingInvoice', 'invoices', 'charges'));
	}

    public function downloadInvoice($id)
    {
        if ($id) {
            return Auth::user()->downloadInvoice($id, [
                'vendor' => 'RentGorilla.ca',
                'product' => 'RentGorilla.ca',
             ]);
        } else {
            return abort(404);
        }
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
