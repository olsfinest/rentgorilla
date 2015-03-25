<?php namespace RentGorilla\Repositories;

interface PlanRepository
{
    public function fetchAllPlans();
    public function fetchPlanById($planId);
    public function fetchPlansByOwner($owner);
    public function fetchPlansByInterval($interval);
    public function fetchPlansByOwnerAndInterval($owner, $interval);

}