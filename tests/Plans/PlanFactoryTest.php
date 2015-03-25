<?php

use Laracasts\TestDummy\DbTestCase;
use RentGorilla\Plans\PlanFactory;

class PlanFactoryTest extends DbTestCase {

    public function testPlanFactoryReturnsValidObject() {

        $planData =  [
            'maximumListings' => 50,
            'totalYearlyCost' => 120000,
            'planName' => 'Extra Large',
            'interval' => 'month',
            'owner' => 'company'
        ];

        $plan = PlanFactory::build('Company_ExtraLarge_Monthly', $planData);

        $this->assertInstanceOf('\RentGorilla\Plans\Company\Monthly\Company_ExtraLarge_Monthly', $plan);

    }


    /**
     * @expectedException InvalidArgumentException
     */
    public function testCreateThrowsExceptionIfPlanIdWrong()
    {
        $plan = PlanFactory::build('foo', []);
    }



}