<?php namespace RentGorilla\Http\Controllers;

use Illuminate\Support\MessageBag;
use RentGorilla\Http\Requests;
use RentGorilla\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Input;
use Auth;
use RentGorilla\Http\Requests\ApplyCouponRequest;
use RentGorilla\Http\Requests\CancelSubscriptionRequest;
use RentGorilla\Http\Requests\ChangePlanRequest;
use RentGorilla\Http\Requests\ResumeSubscriptionRequest;
use RentGorilla\Http\Requests\SubscriptionRequest;
use RentGorilla\Http\Requests\UpdateCardRequest;
use RentGorilla\Repositories\RentalRepository;

class SubscriptionController extends Controller {

    protected $rentalRepository;

    function __construct(RentalRepository $rentalRepository)
    {
        $this->middleware('auth');
        $this->rentalRepository = $rentalRepository;
    }

    public function subscribe(SubscriptionRequest $request)
    {

        try {

            if($request->coupon_code) {
                Auth::user()->subscription($request->stripe_plan)->withCoupon($request->coupon_code)->create($request->stripe_token, [
                'email' => Auth::user()->email]);
            } else {
                Auth::user()->subscription($request->stripe_plan)->create($request->stripe_token, [
                'email' => Auth::user()->email]);
            }

        } catch (\Exception $e) {
            $messages = new MessageBag();
            $messages->add('Stripe Error', $e->getMessage());
            return redirect()->back()->withErrors($messages);
        }

        return redirect()->back()->with('flash_message', 'Thank you! Your subscription has begun!');

    }

    public function applyCoupon(ApplyCouponRequest $request)
    {
        try {

            Auth::user()->applyCoupon($request->coupon_code);

        } catch (\Exception $e) {
            $messages = new MessageBag();
            $messages->add('Stripe Error', $e->getMessage());
            return redirect()->back()->withErrors($messages);
        }

        return redirect()->back()->with('flash_message', 'Your coupon has been applied!');

    }

    public function changePlan(ChangePlanRequest $request)
    {
        try {
            if (Auth::user()->cancelled() && Auth::user()->getStripePlan() === $request->stripe_plan && ! Auth::user()->expired()) {
                Auth::user()->subscription(Auth::user()->getStripePlan())->resume(null);
                $message = 'Your plan has been resumed!';
            } else {
                Auth::user()->subscription($request->stripe_plan)->swap();
                $message = 'Your plan has been changed!';
            }
        } catch (\Exception $e) {
            $messages = new MessageBag();
            $messages->add('Stripe Error', $e->getMessage());
            return redirect()->back()->withErrors($messages);
        }

        return redirect()->back()->with('flash_message', $message);

    }

    public function updateCard(UpdateCardRequest $request)
    {

        try {

                Auth::user()->updateCard($request->stripe_token);

        } catch (\Exception $e) {

            dd($e);

            $messages = new MessageBag();
            $messages->add('Stripe Error', $e->getMessage());
            return redirect()->back()->withErrors($messages);
        }

        return redirect()->back()->with('flash_message', 'Your card has been updated!');

    }

    public function cancelSubscription(CancelSubscriptionRequest $request)
    {
        try {

            Auth::user()->subscription()->cancel();

            $this->rentalRepository->deactivateAllForUser(Auth::user());

        } catch (\Exception $e) {

            $messages = new MessageBag();
            $messages->add('Stripe Error', $e->getMessage());
            return redirect()->back()->withErrors($messages);
        }

        return redirect()->back()->with('flash_message', 'We are sorry to see you go!');
    }

}
