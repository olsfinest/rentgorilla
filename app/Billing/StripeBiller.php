<?php namespace RentGorilla\Billing;

use Stripe\Charge;
use Stripe\Customer;
use Stripe\Plan;

class StripeBiller implements Biller
{

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
        }

        return null;
    }

    public function deleteAccount($customer_id)
    {
        $cu = $this->getCustomerById($customer_id);
        return $cu->delete();
    }

    public function getCustomerById($customer_id)
    {
        return Customer::retrieve($customer_id);
    }

}