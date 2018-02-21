<?php namespace RentGorilla\Http\Controllers;

use Auth;
use RentGorilla\Billing\Biller;
use RentGorilla\Plans\Subscription;
use RentGorilla\Http\Requests\SupportRequest;
use RentGorilla\Commands\ModifyProfileCommand;
use RentGorilla\Commands\ModifySettingsCommand;
use RentGorilla\Commands\SupportRequestCommand;
use RentGorilla\Http\Requests\ModifyProfileRequest;
use RentGorilla\Http\Requests\ModifySettingsRequest;

class SettingsController extends Controller {


    /**
     * @var Biller
     */
    protected $biller;

    public function __construct(Biller $biller)
    {
        $this->middleware('auth');
        $this->middleware('sensitive', ['only' => ['showPaymentHistory', 'downloadInvoice', 'showUpdateCard']]);
        $this->biller = $biller;
    }

    public function showProfile()
	{
        $profile = Auth::user()->profile;

		return view('settings.profile', compact('profile'));
	}

    public function updateProfile(ModifyProfileRequest $request)
    {
        $this->dispatchFrom(ModifyProfileCommand::class, $request, [
            'user_id' => Auth::user()->id,
            'photo' => $request->file('photo')
        ]);

        return redirect()->back()->with('flash:success', 'Your profile has been updated!');
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
        }

        return abort(404);
    }

	public function showUpdateCard()
	{
		return view('settings.update-card');
	}

    public function showSupport()
    {
        return view('settings.contact');
    }

    public function showSettings()
    {
        return view('settings.settings');
    }

    public function saveSettings(ModifySettingsRequest $request)
    {
        $this->dispatchFrom(ModifySettingsCommand::class, $request, [
            'user_id' => Auth::user()->id
        ]);

        return redirect()->back()->with('flash:success', 'Settings updated!');
    }

    public function sendContact(SupportRequest $request)
    {
        $this->dispatchFrom(SupportRequestCommand::class, $request, [
            'user_id' => Auth::user()->id
        ]);

        return redirect()->back()->with('flash:success', 'Your support request was sent!');
    }
}
