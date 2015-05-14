<?php namespace RentGorilla\Billing;

use Stripe\Charge;
use Stripe\Plan;

class StripeBiller {

    public function getPlan($planID)
    {
        return Plan::retrieve($planID);
    }

    public function getCharges($customer_id)
    {

        $charges = Charge::all(['customer' => $customer_id]);

        return count($charges['data']) > 0 ? $charges['data'] : null;

    }

}