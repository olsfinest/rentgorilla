<?php namespace RentGorilla\Billing;

use Stripe_Charge;
use Stripe_Plan;

class StripeBiller {

    public function getPlan($planID)
    {
        return Stripe_Plan::retrieve($planID);
    }

    public function getCharges($customer_id)
    {

        $charges = Stripe_Charge::all(['customer' => $customer_id]);

        return count($charges['data']) > 0 ? $charges['data'] : null;

    }

}