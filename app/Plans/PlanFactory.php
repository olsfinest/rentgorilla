<?php namespace RentGorilla\Plans;

use InvalidArgumentException;

class PlanFactory {

    public static function build($planId, array $planData)
    {
        $namespace = explode('_', $planId);

        if(count($namespace) !== 3) {
            throw new InvalidArgumentException("Invalid planId given: {$planId}");
        }

        $plan = sprintf('RentGorilla\Plans\%s\%s\%s', $namespace[0], $namespace[2], $planId);

        if(class_exists($plan)) {

            $instance = new $plan();
            $instance->setPlanName($planData['planName']);
            $instance->setMaximumListings($planData['maximumListings']);
            $instance->setTotalYearlyCost($planData['totalYearlyCost']);
            $instance->setInterval($planData['interval']);
            $instance->setOwner($planData['owner']);

            return $instance;

        } else {
            throw new InvalidArgumentException("Invalid planId given: {$planId}");
        }
    }
}