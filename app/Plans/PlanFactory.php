<?php namespace RentGorilla\Plans;


class PlanFactory {

    public static function build($planId, array $planData)
    {
            $plan = new Plan();
            $plan->setPlanId($planId);
            $plan->setPlanName($planData['planName']);
            $plan->setMaximumListings($planData['maximumListings']);
            $plan->setTotalYearlyCost($planData['totalYearlyCost']);
            $plan->setInterval($planData['interval']);
            $plan->setIsLegacy($planData['isLegacy']);

            return $plan;
    }
}