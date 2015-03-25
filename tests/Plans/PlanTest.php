<?php

use Laracasts\TestDummy\DbTestCase;
use RentGorilla\Plans\Plan;

class PlanTest extends DbTestCase {

    public function testPlan()
    {
        $cents = 200;

        $this->assertEquals(2, Plan::toDollars($cents));

    }

}