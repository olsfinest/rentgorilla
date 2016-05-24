<?php namespace RentGorilla\Billing;

use RentGorilla\User;
use Stripe\Customer;
use Stripe\Charge;
use Stripe\Plan;
use Log;

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

    public function deleteAccount(User $user)
    {
        if($user->readyForBilling()) {
            try {
                $cu = $this->getCustomerById($user->getStripeId());
                $cu->delete();
                Log::info('Deleted stripe user ' . $user->getStripeId());
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        }
    }

    public function getCustomerById($customer_id)
    {
        return Customer::retrieve($customer_id);
    }

    public function updateEmail(User $user)
    {
        if($user->readyForBilling()) {
            try {
                $cu = $this->getCustomerById($user->getStripeId());
                $cu->email = $user->email;
                $cu->save();
                Log::info('Updated stripe user email ' . $user->email);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        }
    }

}