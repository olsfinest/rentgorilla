<?php namespace RentGorilla\Billing;

use RentGorilla\User;

interface Biller
{
    public function getPlan($planID);
    public function getCharges($customer_id);
    public function deleteAccount(User $user);
    public function getCustomerById($customer_id);
    public function updateEmail(User $user);
}