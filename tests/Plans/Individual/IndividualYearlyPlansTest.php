<?php

use Laracasts\TestDummy\DbTestCase;
use RentGorilla\Plans\Plan;
use RentGorilla\Plans\PlanService;

class IndividualYearlyPlansTest extends DbTestCase {

    protected $planService;

    public function setUp()
    {
        parent::setUp();

        $repo = App::make('RentGorilla\Repositories\PlanRepository');
        $this->planService = new PlanService($repo);

    }

    public function testIndividualLargeYearly()
    {
        $plan = $this->planService->fetchPlanById('Individual_Large_Yearly');

        $this->assertEquals(9, Plan::toDollars($plan->monthlyBilledPrice()));
        $this->assertEquals('Large', $plan->planName());
        $this->assertEquals(4, $plan->maximumListings());
        $this->assertEquals(108, Plan::toDollars($plan->totalYearlyCost()));
        $this->assertTrue($plan->isYearly());
        $this->assertEquals('individual', $plan->owner());
    }

    public function testIndividualMediumYearly()
    {
        $plan = $this->planService->fetchPlanById('Individual_Medium_Yearly');

        $this->assertEquals(5, Plan::toDollars($plan->monthlyBilledPrice()));
        $this->assertEquals('Medium', $plan->planName());
        $this->assertEquals(2, $plan->maximumListings());
        $this->assertEquals(60, Plan::toDollars($plan->totalYearlyCost()));
        $this->assertTrue($plan->isYearly());
        $this->assertEquals('individual', $plan->owner());
    }

    public function testIndividualSmallYearly()
    {
        $plan = $this->planService->fetchPlanById('Individual_Small_Yearly');

        $this->assertEquals(0, Plan::toDollars($plan->monthlyBilledPrice()));
        $this->assertEquals('Small', $plan->planName());
        $this->assertEquals(1, $plan->maximumListings());
        $this->assertEquals(0, Plan::toDollars($plan->totalYearlyCost()));
        $this->assertTrue($plan->isYearly());
        $this->assertEquals('individual', $plan->owner());
    }

}