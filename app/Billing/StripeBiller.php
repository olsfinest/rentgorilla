<?php namespace RentGorilla\Billing;

use Stripe_Plan;

class StripeBiller {

    public function getPlan($planID)
    {
        return Stripe_Plan::retrieve($planID);
    }

}