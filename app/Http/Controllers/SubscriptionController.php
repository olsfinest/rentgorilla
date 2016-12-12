<?php namespace RentGorilla\Http\Controllers;

use RentGorilla\Http\Requests\ResumeSubscriptionRequest;
use RentGorilla\Http\Requests\CancelSubscriptionRequest;
use RentGorilla\Http\Requests\SubscriptionRequest;
use RentGorilla\Http\Requests\ApplyCouponRequest;
use RentGorilla\Http\Requests\ChangePlanRequest;
use RentGorilla\Http\Requests\UpdateCardRequest;
use RentGorilla\Repositories\RentalRepository;
use RentGorilla\Http\Controllers\Controller;
use RentGorilla\Mailers\UserMailer;
use RentGorilla\Http\Requests;
use Illuminate\Http\Request;
use Subscription;
use Input;
use Auth;
use Log;

class SubscriptionController extends Controller {

    protected $rentalRepository;
    /**
     * @var UserMailer
     */
    protected $mailer;

    function __construct(RentalRepository $rentalRepository, UserMailer $mailer)
    {
        $this->middleware('auth');
        $this->rentalRepository = $rentalRepository;
        $this->mailer = $mailer;
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

        try {

            if(Auth::user()->readyForBilling()) {

                $customer = Auth::user()->subscription()->getStripeCustomer();

                if ($request->coupon_code) {
                    Auth::user()->setTrialEndDate(null)->subscription($plan_id)->withCoupon($request->coupon_code)->create(null, [], $customer);
                } else {
                    Auth::user()->setTrialEndDate(null)->subscription($plan_id)->create(null, [], $customer);
                }

            } else {

                if ($request->coupon_code) {
                    Auth::user()->setTrialEndDate(null)->subscription($plan_id)->withCoupon($request->coupon_code)->create($request->stripe_token, [
                        'email' => Auth::user()->email]);
                } else {
                    Auth::user()->setTrialEndDate(null)->subscription($plan_id)->create($request->stripe_token, [
                        'email' => Auth::user()->email]);
                }
            }

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['Stripe Error' => $e->getMessage()]);
        }

        $activeRentalCount = $this->rentalRepository->getActiveRentalCountForUser(Auth::user());

        $isDowngrade = false;

        if($activeRentalCount) {
            if ( ! $plan->unlimited() && $activeRentalCount > $plan->maximumListings()) {
                $difference = $activeRentalCount - $plan->maximumListings();
                $isDowngrade = true;
                $this->rentalRepository->downgradePlanCapacityForUser(Auth::user(), $plan->maximumListings());
            }
        }

        $this->mailer->sendSubscriptionBegun(Auth::user(), $isDowngrade);

        Log::info('Subscription begun', ['user_id' => Auth::id(), 'plan' => $plan_id]);

        if($isDowngrade && ! empty($difference)) {
            return redirect()->route('changePlan')->with('flash:success', 'Thank you! Your subscription has begun! We had to deactivate ' . $difference . ' of your properties as your new plan\'s capacity is ' . $plan->maximumListings());
        }

        return redirect()->route('changePlan')->with('flash:success', 'Thank you! Your subscription has begun!');
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

        if($isDowngrade) {

            $activeRentalCount = $this->rentalRepository->getActiveRentalCountForUser(Auth::user());

            if($activeRentalCount) {
                if ( ! $newPlan->unlimited() && $activeRentalCount > $newPlan->maximumListings()) {
                    $difference = $activeRentalCount - $newPlan->maximumListings();
                    $this->rentalRepository->downgradePlanCapacityForUser(Auth::user(), $newPlan->maximumListings());
                }
            }
        }

        $this->mailer->sendSubscriptionChanged(Auth::user(), $isDowngrade);
        $this->clearCurrentPeriodEnd();

        Log::info('Subscription swapped', ['user_id' => Auth::id(), 'new_plan' => $newPlan->id(), 'old_plan' =>  $plan->id()]);

        if($isDowngrade && ! empty($difference)) {
            return redirect()->route('changePlan')->with('flash:success', 'Thank you! Your subscription plan has been changed! We had to deactivate ' . $difference . ' of your properties as your new plan\'s capacity is ' . $newPlan->maximumListings());
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

     //   $this->mailer->sendSubscriptionCancelled(Auth::user());

        Log::info('Subscription cancelled', ['user_id' => Auth::id(), 'plan' => Auth::user()->getStripePlan()]);

        return redirect()->route('changePlan')->with('flash:success', 'Your subscription has been cancelled.');
    }

    private function clearCurrentPeriodEnd()
    {
        Auth::user()->current_period_end = null;
        Auth::user()->save();
    }
}