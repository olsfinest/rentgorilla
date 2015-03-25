<?php

use Laracasts\TestDummy\DbTestCase;
use RentGorilla\Plans\Plan;
use RentGorilla\Plans\PlanService;

class IndividualMonthlyPlansTest extends DbTestCase
{

    private $planService;

    public function setUp()
    {
        parent::setUp();

        $repo = App::make('RentGorilla\Repositories\PlanRepository');
        $this->planService = new PlanService($repo);

    }

    public function testIndividualLargeMonthly()
    {

        $plan = $this->planService->fetchPlanById('Individual_Large_Monthly');

        $this->assertEquals(12, Plan::toDollars($plan->monthlyBilledPrice()));
        $this->assertEquals('Large', $plan->planName());
        $this->assertEquals(4, $plan->maximumListings());
        $this->assertEquals(144, Plan::toDollars($plan->totalYearlyCost()));
        $this->assertFalse($plan->isYearly());
        $this->assertEquals('individual', $plan->owner());
    }

    public function testIndividualMediumMonthly()
    {

        $plan = $this->planService->fetchPlanById('Individual_Medium_Monthly');

        $this->assertEquals(7, Plan::toDollars($plan->monthlyBilledPrice()));
        $this->assertEquals('Medium', $plan->planName());
        $this->assertEquals(2, $plan->maximumListings());
        $this->assertEquals(84, Plan::toDollars($plan->totalYearlyCost()));
        $this->assertFalse($plan->isYearly());
        $this->assertEquals('individual', $plan->owner());
    }

    public function testIndividualSmallMonthly()
    {

        $plan = $this->planService->fetchPlanById('Individual_Small_Monthly');

        $this->assertEquals(0, Plan::toDollars($plan->monthlyBilledPrice()));
        $this->assertEquals('Small', $plan->planName());
        $this->assertEquals(1, $plan->maximumListings());
        $this->assertEquals(0, $plan->totalYearlyCost());
        $this->assertFalse($plan->isYearly());
        $this->assertEquals('individual', $plan->owner());
    }

}