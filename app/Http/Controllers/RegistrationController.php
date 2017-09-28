<?php namespace RentGorilla\Http\Controllers;

use Auth;
use RentGorilla\Commands\ConfirmEmailCommand;
use RentGorilla\Commands\RegistrationCommand;
use RentGorilla\Commands\ResendConfirmationCommand;
use RentGorilla\Http\Requests;
use RentGorilla\Http\Controllers\Controller;

use Illuminate\Http\Request;

use RentGorilla\Http\Requests\RegistrationRequest;
use RentGorilla\Http\Requests\ResendConfirmationRequest;
use RentGorilla\Mailers\UserMailer;

class RegistrationController extends Controller {

	public function register(RegistrationRequest $registrationRequest)
    {
        $user = $this->dispatchFrom(RegistrationCommand::class, $registrationRequest);

        $message = view('app.registration-message', compact('user'))->render();

        return response()->json(['success' => true, 'message' => $message]);
    }

    public function confirm($token)
    {
        $user = $this->dispatch(new ConfirmEmailCommand($token));

        Auth::login($user);

        return redirect()->route('rental.index', ['verified' => 1])->with('flash:success', 'Thank you, your account has been verified!');
    }

    public function resendConfirmation(ResendConfirmationRequest $request)
    {
        $user = $this->dispatchFrom(ResendConfirmationCommand::class, $request);

        $message = view('app.registration-message', compact('user'))->render();

        return response()->json(['success' => true, 'message' => $message], 200);
    }


    public function deleteAccount()
    {
        //get all rentals
        //delete the images
        //cancel active stripe subscription
        //delete stripe customer?
        //delete all db entries for the user
    }





}