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

        if(count($charges['data']) > 0) {

           return array_filter($charges['data'], function($obj){
               return  ! is_null($obj->description) ;
           });

        } else {
            return null;
        }

    }

}