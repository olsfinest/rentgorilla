<?php namespace RentGorilla\Plans;

interface PlanInterface {
    public function rentalPropertyTypes();
    public function monthlyBilledPrice();
    public function totalYearlyCost();
    public function planName();
    public function maximumListings();
    public function isYearly();
    public function isMonthly();
}