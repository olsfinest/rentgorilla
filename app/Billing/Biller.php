<?php namespace RentGorilla\Billing;

interface Biller
{
    public function getPlan($planID);
    public function getCharges($customer_id);
    public function deleteAccount($customer_id);
    public function getCustomerById($customer_id);
}