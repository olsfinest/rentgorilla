<?php

use Laracasts\TestDummy\DbTestCase;
use RentGorilla\Plans\PlanService;

class PlanServiceTest extends DbTestCase
{

    private $service;

    public function setUp()
    {
        parent::setUp();

        $repo = App::make('RentGorilla\Repositories\PlanRepository');
        $this->service = new PlanService($repo);

    }

    public function testItFetchesAllPlans()
    {

        $plans = $this->service->fetchAllPlans();

        $this->assertCount(14, $plans, 'all plans');

    }

    public function testItFetchesAPlanById()
    {
        $plan = $this->service->fetchPlanById('Company_ExtraLarge_Monthly');

        $this->assertInstanceOf('\RentGorilla\Plans\Company\Monthly\Company_ExtraLarge_Monthly', $plan);
    }

    public function testItFetchesPlansByOwner()
    {

        $plans = $this->service->fetchPlansByOwner('company');

        $this->assertCount(8, $plans, 'by owner');

    }

    public function testItFetchesPlansByInterval()
    {

        $plans = $this->service->fetchPlansByInterval('year');

        $this->assertCount(7, $plans, 'by interval');

    }

    public function testItFetchesPlansByOwnerAndInterval()
    {

        $plans = $this->service->fetchPlansByOwnerAndInterval('company', 'year');

        $this->assertCount(4, $plans, 'by owner and interval');

    }

}