<?php

use Laracasts\TestDummy\DbTestCase;
use RentGorilla\Plans\Plan;
use RentGorilla\Plans\PlanService;


class CompanyMonthlyPlansTest extends DbTestCase {

    private $planService;

    public function setUp()
    {
        parent::setUp();

        $repo = App::make('RentGorilla\Repositories\PlanRepository');
        $this->planService = new PlanService($repo);

    }

    public function testCompanyExtraLargeMonthly()
    {

        $plan = $this->planService->fetchPlanById('Company_ExtraLarge_Monthly');

        $this->assertEquals(100, Plan::toDollars($plan->monthlyBilledPrice()));
        $this->assertEquals('Extra Large', $plan->planName());
        $this->assertEquals(50, $plan->maximumListings());
        $this->assertEquals(1200, Plan::toDollars($plan->totalYearlyCost()));
        $this->assertFalse($plan->isYearly());
        $this->assertEquals('company', $plan->owner());
    }

    public function testCompanyLargeMonthly()
    {

        $plan = $this->planService->fetchPlanById('Company_Large_Monthly');

        $this->assertEquals(50, Plan::toDollars($plan->monthlyBilledPrice()));
        $this->assertEquals('Large', $plan->planName());
        $this->assertEquals(20, $plan->maximumListings());
        $this->assertEquals(600, Plan::toDollars($plan->totalYearlyCost()));
        $this->assertFalse($plan->isYearly());
        $this->assertEquals('company', $plan->owner());
    }

    public function testCompanyMediumMonthly()
    {

        $plan = $this->planService->fetchPlanById('Company_Medium_Monthly');

        $this->assertEquals(40, Plan::toDollars($plan->monthlyBilledPrice()));
        $this->assertEquals('Medium', $plan->planName());
        $this->assertEquals(10, $plan->maximumListings());
        $this->assertEquals(480, Plan::toDollars($plan->totalYearlyCost()));
        $this->assertFalse($plan->isYearly());
        $this->assertEquals('company', $plan->owner());
    }

    public function testCompanySmallMonthly()
    {

        $plan = $this->planService->fetchPlanById('Company_Small_Monthly');

        $this->assertEquals(20, Plan::toDollars($plan->monthlyBilledPrice()));
        $this->assertEquals('Small', $plan->planName());
        $this->assertEquals(5, $plan->maximumListings());
        $this->assertEquals(240, Plan::toDollars($plan->totalYearlyCost()));
        $this->assertFalse($plan->isYearly());
        $this->assertEquals('company', $plan->owner());
    }

}