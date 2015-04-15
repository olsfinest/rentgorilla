<?php namespace RentGorilla\Repositories;

interface PlanRepository
{
    public function fetchAllPlans();
    public function fetchPlanById($planId);
    public function fetchPlansByInterval($interval);
    public function fetchPlansForSelect();

}