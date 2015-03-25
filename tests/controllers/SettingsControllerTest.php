<?php

use Illuminate\Support\Facades\Auth;
use Laracasts\TestDummy\DbTestCase;
use Laracasts\TestDummy\Factory;

class SettingsControllerTest extends DbTestCase
{

   public $user;


   public function setUp()
   {
       parent::setUp();

       $this->user = Factory::create('RentGorilla\User');

       Auth::loginUsingId($this->user->id);

   }


   public function tearDown()
   {
       Auth::logout();
   }


    public function testShowChangePlan()
    {
        $this->route('get', 'changePlan');
        $this->assertResponseOk();
    }

    public function testShowApplyCoupon()
    {
        $this->route('get', 'applyCoupon');
        $this->assertResponseOk();
    }

    public function testShowPaymentHistory()
    {
        $this->route('get', 'paymentHistory');
        $this->assertResponseOk();
    }

    public function testShowUpdateCard()
    {
        $this->route('get', 'updateCard');
        $this->assertResponseOk();
    }

    public function testShowCancelSubscription()
    {
        $this->route('get', 'cancelSubscription');
        $this->assertResponseOk();
    }
}