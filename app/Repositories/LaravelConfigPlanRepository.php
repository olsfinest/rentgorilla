<?php namespace RentGorilla\Repositories;

use Config;
use RentGorilla\Plans\PlanFactory;

class LaravelConfigPlanRepository implements PlanRepository
{
    protected $plans;
    protected $plansCollection;

    /**
     * LaravelConfigPlanRepository constructor.
     * @param $plans
     */
    public function __construct($plans)
    {
        $this->plans = collect($plans);
        $this->fetchAllPlans();
    }

    public function fetchAllPlans()
    {
        $this->plansCollection = $this->plans->map(function($value, $key) {
            return PlanFactory::build($key, $value);
        });
    }

    public function fetchPlansForSelect()
    {
        $plans = $this->fetchPlansByLegacy(false);

        $plans = $plans->sortBy(function ($plan){
            return $plan->totalYearlyCost();
        });

        return $plans->keyBy(function ($plan) {
            return $plan->id();
        })->map(function ($plan) {
            return $plan->getNameAndPrice();
        });
    }

    public function fetchPlanById($planId)
    {
        $planData = Config::get('plans.plans.' . $planId);

        if( ! $planData) return null;

        return PlanFactory::build($planId, $planData);
    }

    public function fetchPlansByInterval($interval)
    {
        return $this->plansCollection->filter(function ($plan) use ($interval) {
            return $plan->interval() === $interval;
        });
    }

    public function fetchPlansByLegacy($isLegacy)
    {
        return $this->plansCollection->filter(function ($plan) use ($isLegacy) {
            return $plan->isLegacy() === $isLegacy;
        });
    }
}