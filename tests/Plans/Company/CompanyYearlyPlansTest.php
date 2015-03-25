<?php

use Laracasts\TestDummy\DbTestCase;
use RentGorilla\Plans\Plan;
use RentGorilla\Plans\PlanService;

class CompanyYearlyPlansTest extends DbTestCase {

    private $planService;

    public function setUp()
    {
        parent::setUp();

        $repo = App::make('RentGorilla\Repositories\PlanRepository');
        $this->planService = new PlanService($repo);

    }


    public function testCompanyExtraLargeYearly()
    {

        $plan = $this->planService->fetchPlanById('Company_ExtraLarge_Yearly');

        $this->assertEquals(83.33, Plan::toDollars($plan->monthlyBilledPrice()));
        $this->assertEquals('Extra Large', $plan->planName());
        $this->assertEquals(50, $plan->maximumListings());
        $this->assertEquals(1000, Plan::toDollars($plan->totalYearlyCost()));
        $this->assertTrue($plan->isYearly());
        $this->assertEquals('company', $plan->owner());
    }

    public function testCompanyLargeYearly()
    {

        $plan = $this->planService->fetchPlanById('Company_Large_Yearly');

        $this->assertEquals(45, Plan::toDollars($plan->monthlyBilledPrice()));
        $this->assertEquals('Large', $plan->planName());
        $this->assertEquals(20, $plan->maximumListings());
        $this->assertEquals(540, Plan::toDollars($plan->totalYearlyCost()));
        $this->assertTrue($plan->isYearly());
        $this->assertEquals('company', $plan->owner());

    }

    public function testCompanyMediumYearly()
    {

        $plan = $this->planService->fetchPlanById('Company_Medium_Yearly');

        $this->assertEquals(35, Plan::toDollars($plan->monthlyBilledPrice()));
        $this->assertEquals('Medium', $plan->planName());
        $this->assertEquals(10, $plan->maximumListings());
        $this->assertEquals(420, Plan::toDollars($plan->totalYearlyCost()));
        $this->assertTrue($plan->isYearly());
        $this->assertEquals('company', $plan->owner());
    }

    public function testCompanySmallYearly()
    {
        $plan = $this->planService->fetchPlanById('Company_Small_Yearly');

        $this->assertEquals(15, Plan::toDollars($plan->monthlyBilledPrice()));
        $this->assertEquals('Small', $plan->planName());
        $this->assertEquals(5, $plan->maximumListings());
        $this->assertEquals(180, Plan::toDollars($plan->totalYearlyCost()));
        $this->assertTrue($plan->isYearly());
        $this->assertEquals('company', $plan->owner());

    }

}