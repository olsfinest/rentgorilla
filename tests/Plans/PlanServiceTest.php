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

        $this->assertCount(7, $plans, 'all plans');

    }

    public function testItFetchesAPlanById()
    {
        $plan = $this->service->fetchPlanById('Business_Monthly');

        $this->assertInstanceOf('\RentGorilla\Plans\Plan', $plan);
    }


    public function testItFetchesPlansByInterval()
    {

        $plans = $this->service->fetchPlansByInterval('year');

        $this->assertCount(3, $plans, 'by interval');

    }

}