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
use RentGorilla\Mailers\UserMailer;
use RentGorilla\Plans\Plan;
use RentGorilla\Repositories\RentalRepository;
use Subscription;
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
        return view('settings.change-plan');
    }

    public function showSwapSubscription($plan_id)
    {
        $plan = Subscription::plan(Auth::user()->getStripePlan());
        $newPlan = Subscription::plan($plan_id);

        if( ! $plan || ! $newPlan) {
            app()->abort(404);
        }

        $isDowngrade = $this->isDowngrade($plan, $newPlan);

        return view('settings.swap-plan', compact('plan', 'newPlan', 'isDowngrade'));
    }

    private function isDowngrade(Plan $oldPlan, Plan $newPlan)
    {
        if($newPlan->unlimited() || $oldPlan->unlimited()) {
            if($newPlan->unlimited()) {
                return false;
            } else {
                return true;
            }
        } else {
            return $newPlan->maximumListings() < $oldPlan->maximumListings();
        }

    }

    public function showSubscribe($plan_id)
    {
        // make sure it is a valid plan
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
        $plan = Subscription::plan(Auth::user()->getStripePlan())->planName();

        return view('settings.resume-subscription', compact('plan'));
    }

    public function subscribe($plan_id, SubscriptionRequest $request)
    {
        // make sure it is a valid plan
        $plan = Subscription::plan($plan_id);

        if( ! $plan) {
            app()->abort(404);
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
            $messages = new MessageBag();
            $messages->add('Stripe Error', $e->getMessage());
            return redirect()->back()->withErrors($messages);
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
        } else {
            return redirect()->route('changePlan')->with('flash:success', 'Thank you! Your subscription has begun!');
        }

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

        Log::info('Coupon applied', ['user_id' => Auth::id(), 'coupon_code' => $request->coupon_code ]);

        return redirect()->back()->with('flash:success', 'Your coupon has been applied!');

    }

    public function swapSubscription($plan_id, ChangePlanRequest $request)
    {

        $plan = Subscription::plan(Auth::user()->getStripePlan());
        $newPlan = Subscription::plan($plan_id);

        //plans exist and you cannot swap to the same plan
        if( ! $plan || ! $newPlan || Auth::user()->getStripePlan() === $plan_id) {
            app()->abort(404);
        }

        $isDowngrade = $this->isDowngrade($plan, $newPlan);

        try {

            Auth::user()->subscription($plan_id)->swap();


        } catch (\Exception $e) {
            $messages = new MessageBag();
            $messages->add('Stripe Error', $e->getMessage());
            return redirect()->back()->withErrors($messages);
        }

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

        Log::info('Subscription swapped', ['user_id' => Auth::id(), 'new_plan' => $newPlan->id(), 'old_plan' =>  $plan->id()]);

        if($isDowngrade && ! empty($difference)) {
            return redirect()->route('changePlan')->with('flash:success', 'Thank you! Your subscription plan has been changed! We had to deactivate ' . $difference . ' of your properties as your new plan\'s capacity is ' . $newPlan->maximumListings());
        } else {
            return redirect()->route('changePlan')->with('flash:success', 'Thank you! Your subscription has been changed!');
        }

    }

    public function resumeSubscription(ResumeSubscriptionRequest $request)
    {
        try {

            Auth::user()->subscription(Auth::user()->getStripePlan())->resume(null);

            $this->mailer->sendSubscriptionResumed(Auth::user());

        } catch (\Exception $e) {
            $messages = new MessageBag();
            $messages->add('Stripe Error', $e->getMessage());
            return redirect()->back()->withErrors($messages);
        }

        Log::info('Subscription resumed', ['user_id' => Auth::id(), 'plan' => Auth::user()->getStripePlan()]);

        return redirect()->route('changePlan')->with('flash:success', 'Your plan has been resumed!');
    }

    public function updateCard(UpdateCardRequest $request)
    {

        try {

            Auth::user()->updateCard($request->stripe_token);

        } catch (\Exception $e) {

            $messages = new MessageBag();
            $messages->add('Stripe Error', $e->getMessage());
            return redirect()->back()->withErrors($messages);
        }

        Log::info('Credit card updated', ['user_id' => Auth::id()]);

        return redirect()->back()->with('flash:success', 'Your card has been updated!');

    }

    public function cancelSubscription(CancelSubscriptionRequest $request)
    {

        try {

            Auth::user()->subscription()->cancel();

        } catch (\Exception $e) {

            $messages = new MessageBag();
            $messages->add('Stripe Error', $e->getMessage());
            return redirect()->back()->withErrors($messages);
        }

        $this->mailer->sendSubscriptionCancelled(Auth::user());

        Log::info('Subscription cancelled', ['user_id' => Auth::id(), 'plan' => Auth::user()->getStripePlan()]);

        return redirect()->route('changePlan')->with('flash:success', 'Your subscription has been cancelled.');
    }

}