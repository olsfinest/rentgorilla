<?php

use Illuminate\Support\Facades\Session;
use Laracasts\TestDummy\DbTestCase;

class AppControllerTest extends DbTestCase
{
    public function testShowHome()
    {
        $this->route('get', 'home');
        $this->assertResponseOk();
    }

    public function testShowList()
    {
        $this->route('get', 'list');
        $this->assertResponseOk();
    }

    public function testShowMap()
    {
        $this->route('get', 'map');
        $this->assertResponseOk();
    }

    public function testClearSearch()
    {
        Session::put('type', 'test');
        Session::put('availability', 'test');
        Session::put('beds', 'test');
        Session::put('price', 'test');

        $this->route('post', 'clearSearch');

        $this->assertNull(Session::get('type'));
        $this->assertNull(Session::get('availability'));
        $this->assertNull(Session::get('beds'));
        $this->assertNull(Session::get('price'));
    }
}