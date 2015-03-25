<?php namespace RentGorilla\Composers;

class SettingsComposer {

    public function compose($view)
    {
        $links = [
            ['route' => 'rental.index', 'text' => 'My Rentals'],
            ['route' => 'favourites', 'text' => 'My Favourites'],
            ['route' => 'profile', 'text' => 'Profile'],
            ['route' => 'changePlan', 'text' => 'Subscription'],
            ['route' => 'applyCoupon', 'text' => 'Coupon'],
            ['route' => 'paymentHistory', 'text' => 'Payment History'],
            ['route' => 'updateCard', 'text' => 'Credit Card'],
            ['route' => 'cancelSubscription', 'text' => 'Cancel'],
        ];

       $view->with(compact('links'));
    }

}