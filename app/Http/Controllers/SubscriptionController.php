<?php namespace RentGorilla\Http\Controllers;

use RentGorilla\Http\Requests\ResumeSubscriptionRequest;
use RentGorilla\Http\Requests\CancelSubscriptionRequest;
use RentGorilla\Http\Requests\SubscriptionRequest;
use RentGorilla\Http\Requests\ApplyCouponRequest;
use RentGorilla\Http\Requests\ChangePlanRequest;
use RentGorilla\Http\Requests\UpdateCardRequest;
use RentGorilla\Http\Controllers\Controller;
use RentGorilla\Rental\RentalService;
use RentGorilla\Mailers\UserMailer;
use RentGorilla\Http\Requests;
use Illuminate\Http\Request;
use Stripe\Coupon;
use Subscription;
use Input;
use Auth;
use Log;

class SubscriptionController extends Controller {

    /**
     * @var UserMailer
     */
    protected $mailer;

    /**
     * @var RentalService
     */
    protected $rentalService;

    function __construct(UserMailer $mailer, RentalService $rentalService)
    {
        $this->middleware('auth');
        $this->middleware('sensitive');
        $this->mailer = $mailer;
        $this->rentalService = $rentalService;
    }

    public function showChangePlan()
    {
        $plans = Subscription::fetchPlansForSelect()->all();
        $plan = Auth::user()->plan();

        return view('settings.change-plan', compact('plans', 'plan'));
    }

    public function changePlan(Request $request)
    {
        if($request->has('plan_id') && ! Subscription::plan($request->plan_id)) {
            app()->abort(404);
        }
        if($request->subscribe) {
            return redirect()->route('showSubscribe', $request->plan_id);
        }
        if($request->cancel) {
            return redirect()->route('cancelSubscription');
        }
        if($request->swap) {
            return redirect()->route('swapSubscription', $request->plan_id);
        }
        if($request->resume) {
            return redirect()->route('resumeSubscription');
        }
    }

    public function showSwapSubscription($plan_id)
    {
        $plan = Auth::user()->plan();
        $newPlan = Subscription::plan($plan_id);

        if( ! $plan || ! $newPlan) {
            app()->abort(404);
        }

        if($plan->id() === $newPlan->id()) {
            return redirect()->route('changePlan')->with('flash:warning', 'You can\'t swap to the same plan');
        }

        $isDowngrade = Subscription::isDowngrade($plan, $newPlan);

        return view('settings.swap-plan', compact('plan', 'newPlan', 'isDowngrade'));
    }

    public function showSubscribe($plan_id)
    {
        $plan = Subscription::plan($plan_id);

        if( ! $plan ) {
            return app()->abort(404);
        }

        return view('settings.subscribe', compact('plan'));
    }

    public function showApplyCoupon()
    {
        return view('settings.apply-coupon');
    }

    public function showCancelSubscription()
    {
        return view('settings.cancel-subscription');
    }

    public function showResumeSubscription()
    {
        $plan = Auth::user()->plan();

        return view('settings.resume-subscription', compact('plan'));
    }

    public function subscribe($plan_id, SubscriptionRequest $request)
    {

        // make sure it is a valid plan
        $plan = Subscription::plan($plan_id);

        if( ! $plan) {
            app()->abort(404);
        }

        if($plan->isLegacy()) {
            return redirect()->route('changePlan')->with('flash:error', 'That plan is no longer supported');
        }

        $hasCouponCode = $request->has('coupon_code');

        if($hasCouponCode) {
            try {
                $coupon = Coupon::retrieve($request->input('coupon_code'));
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['Stripe Error' => $e->getMessage()]);
            }
        }

        try {

            if(Auth::user()->readyForBilling()) {

                $customer = Auth::user()->subscription()->getStripeCustomer();

                if ($hasCouponCode) {
                    $this->subscribeExistingUserWithCoupon($plan_id, $request->input('coupon_code'), $customer);
                } else {
                    Auth::user()->setTrialEndDate(null)->subscription($plan_id)->create(null, [], $customer);
                }

            } else {

                if ($hasCouponCode) {
                    Auth::user()->setTrialEndDate(null)->subscription($plan_id)->withCoupon($request->input('coupon_code'))->create($request->input('stripe_token'), [
                        'email' => Auth::user()->email]);
                } else {
                    Auth::user()->setTrialEndDate(null)->subscription($plan_id)->create($request->input('stripe_token'), [
                        'email' => Auth::user()->email]);
                }
            }

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['Stripe Error' => $e->getMessage()]);
        }

        list($isDowngrade, $difference) = $this->rentalService->enforceActiveRentalsCountOnSubscribe(Auth::user(), $plan);

        $this->mailer->sendSubscriptionBegun(Auth::user(), $isDowngrade);

        Log::info('Subscription begun', ['user_id' => Auth::id(), 'plan' => $plan_id]);

        $thanks = $hasCouponCode ? 'Thank you! Your subscription has begun and we\'ve applied your coupon!' : 'Thank you! Your subscription has begun!';

        if($isDowngrade && ! empty($difference)) {
            return redirect()->route('changePlan')->with('flash:success', $thanks . '  We had to deactivate ' . $difference . ' of your properties as your new plan\'s capacity is ' . $plan->maximumListings());
        }

        return redirect()->route('changePlan')->with('flash:success', $thanks);
    }

    public function applyCoupon(ApplyCouponRequest $request)
    {
        try {

            Auth::user()->applyCoupon($request->coupon_code);

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['Stripe Error' => $e->getMessage()]);
        }

        Log::info('Coupon applied', ['user_id' => Auth::id(), 'coupon_code' => $request->coupon_code ]);

        return redirect()->back()->with('flash:success', 'Your coupon has been applied!');
    }

    public function swapSubscription($plan_id, ChangePlanRequest $request)
    {
        $plan = Auth::user()->plan();
        $newPlan = Subscription::plan($plan_id);

        //plans exist and you cannot swap to the same plan
        if( ! $plan || ! $newPlan) {
            app()->abort(404);
        }

        if($plan->id() === $newPlan->id()) {
            return redirect()->route('changePlan')->with('flash:warning', 'You can\'t swap to the same plan');
        }

        if($newPlan->isLegacy()) {
            return redirect()->route('changePlan')->with('flash:error', 'That plan is no longer supported');
        }


        try {

            Auth::user()->subscription($plan_id)->swap();

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['Stripe Error' => $e->getMessage()]);
        }

        $isDowngrade = Subscription::isDowngrade($plan, $newPlan);

        list($isDowngrade, $difference) = $this->rentalService->enforceActiveRentalsCountOnSwap(Auth::user(), $newPlan, $isDowngrade);

        $this->mailer->sendSubscriptionChanged(Auth::user(), $isDowngrade);
        $this->clearCurrentPeriodEnd();

        Log::info('Subscription swapped', ['user_id' => Auth::id(), 'new_plan' => $newPlan->id(), 'old_plan' =>  $plan->id()]);

        if($isDowngrade && ! empty($difference)) {
            return redirect()->route('changePlan')->with('flash:success',
                sprintf('Thank you! Your subscription plan has been changed! We had to deactivate %s of your properties as your new plan\'s capacity is %s',
                    $difference,
                    $newPlan->maximumListings()));
        }

        return redirect()->route('changePlan')->with('flash:success', 'Thank you! Your subscription has been changed!');
    }

    public function resumeSubscription(ResumeSubscriptionRequest $request)
    {
         $plan = Auth::user()->plan();

         if($plan->isLegacy()) {
             return redirect()->route('changePlan')->with('flash:error', 'That plan is no longer supported');
         }

        try {

            Auth::user()->subscription(Auth::user()->getStripePlan())->resume(null);

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['Stripe Error' => $e->getMessage()]);
        }

        $this->clearCurrentPeriodEnd();

        $this->mailer->sendSubscriptionResumed(Auth::user());

        Log::info('Subscription resumed', ['user_id' => Auth::id(), 'plan' => Auth::user()->getStripePlan()]);

        return redirect()->route('changePlan')->with('flash:success', 'Your plan has been resumed!');
    }

    public function updateCard(UpdateCardRequest $request)
    {

        try {

            Auth::user()->updateCard($request->stripe_token);

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['Stripe Error' => $e->getMessage()]);
        }

        Log::info('Credit card updated', ['user_id' => Auth::id()]);

        return redirect()->back()->with('flash:success', 'Your card has been updated!');

    }

    public function cancelSubscription(CancelSubscriptionRequest $request)
    {
        try {

            Auth::user()->subscription()->cancel();

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['Stripe Error' => $e->getMessage()]);
        }

        $this->clearCurrentPeriodEnd();

        $this->mailer->sendSubscriptionCancelled(Auth::user());

        Log::info('Subscription cancelled', ['user_id' => Auth::id(), 'plan' => Auth::user()->getStripePlan()]);

        return redirect()->route('changePlan')->with('flash:success', 'Your subscription has been cancelled.');
    }

    private function clearCurrentPeriodEnd()
    {
        Auth::user()->current_period_end = null;
        Auth::user()->save();
    }

    private function subscribeExistingUserWithCoupon($plan_id, $coupon, $customer)
    {
        Auth::user()->setStripeSubscription(
            $customer->updateSubscription($this->buildPayload($plan_id, $coupon))->id
        );

        $customer = Auth::user()->subscription()->getStripeCustomer($customer->id);

        Auth::user()->setTrialEndDate(null);

        Auth::user()->subscription()->updateLocalStripeData($customer, $plan_id);
    }

    private function buildPayload($plan_id, $coupon)
    {
        $payload = [
            'plan' => $plan_id, 'prorate' => true,
            'quantity' => 1, 'coupon' => $coupon
        ];

        if ($taxPercent = Auth::user()->getTaxPercent()) {
            $payload['tax_percent'] = $taxPercent;
        }

        return $payload;
    }
}