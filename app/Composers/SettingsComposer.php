<?php namespace RentGorilla\Composers;

use Auth;

class SettingsComposer {

    public function compose($view)
    {
        $links = [
            ['route' => 'rental.index', 'text' => 'My Properties'],
            ['route' => 'promotions', 'text' => 'Promote Properties'],
            ['route' => 'favourites', 'text' => 'My Favourites'],
            ['route' => 'profile', 'text' => 'Profile'],
            ['route' => 'changePlan', 'text' => 'Subscription'],
            ['route' => 'redeem.show', 'text' => 'Rewards'],

        ];


        //user is a Stripe customer

        if(Auth::user()->readyForBilling()) {

            $links[] = ['route' => 'paymentHistory', 'text' => 'Payment History'];
            $links[] = ['route' => 'updateCard', 'text' => 'Credit Card'];
            $links[] = ['route' => 'applyCoupon', 'text' => 'Coupon'];
        }


        if( Auth::user()->stripeIsActive()) {

            $links[] = ['route' => 'cancelSubscription', 'text' => 'Cancel'];
        }


        $view->with(compact('links'));
    }

}