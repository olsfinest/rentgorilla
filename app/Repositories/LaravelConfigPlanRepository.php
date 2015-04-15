<?php namespace RentGorilla\Repositories;

use Config;
use RentGorilla\Plans\PlanFactory;

class LaravelConfigPlanRepository implements PlanRepository
{
    protected $plans;

    private function loadPlans()
    {
        if(is_null($this->plans)) {
            $this->plans = Config::get('plans');
        }
    }

    public function fetchAllPlans()
    {
        $this->loadPlans();

        if(empty($this->plans)) return null;

        $plans = [];

        foreach ($this->plans as $key => $value) {
            $plans[] = PlanFactory::build($key, $value);
        }

        return $plans;
    }

    public function fetchPlansForSelect()
    {
        $plans = $this->fetchAllPlans();

        $plans = static::numericSort($plans);

        if($plans) {

            $select = [];

            foreach ($plans as $plan) {
                $select[$plan->id()] = $plan->getNameAndPrice();
            }

            return $select;

        } else {
            return null;
        }
    }

    public function fetchPlanById($planId)
    {
        $planData = Config::get('plans.' . $planId);

        if( ! $planData) return null;

        return PlanFactory::build($planId, $planData);
    }

    public function fetchPlansByInterval($interval)
    {
        $plans = $this->fetchAllPlans();

        if($plans) {
            return array_filter($plans, function($obj) use ($interval) {
                return $obj->interval() == $interval;
            });
        }
    }

    public static function numericSort(array $plans)
    {
        usort($plans, function($a, $b)
        {
            if ($a->totalYearlyCost() == $b->totalYearlyCost()) {
                return 0;
            }
            return ($a->totalYearlyCost() < $b->totalYearlyCost()) ? -1 : 1;
        });

        return $plans;
    }

}