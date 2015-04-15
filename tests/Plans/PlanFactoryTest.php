<?php

use Laracasts\TestDummy\DbTestCase;
use RentGorilla\Plans\PlanFactory;

class PlanFactoryTest extends DbTestCase {

    public function testPlanFactoryReturnsValidObject() {

        $planData =  [
            'maximumListings' => 'unlimited',
            'totalYearlyCost' => 28800,
            'planName' => 'Business - Yearly',
            'interval' => 'month'
        ];

        $plan = PlanFactory::build('Business_Monthly', $planData);

        $this->assertInstanceOf('\RentGorilla\Plans\Plan', $plan);

    }






}