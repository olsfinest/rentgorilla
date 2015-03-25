<?php

use Illuminate\Support\Facades\Auth;
use Laracasts\TestDummy\DbTestCase;
use Laracasts\TestDummy\Factory;

class SessionControllerTest extends DbTestCase {

    private $ajaxRequest = ['HTTP_X-Requested-With' => 'XMLHttpRequest'];
    private $ajaxContent = ['HTTP_CONTENT_TYPE' =>'application/json'];
    private $ajaxAccept = ['HTTP_ACCEPT', 'application/json'];

    public function testLogin()
    {
        $user = Factory::create('RentGorilla\User');

        $credentials = ['email' => $user->email, 'password' => 'password'];

        $this->call('post', '/login', $credentials);

        $this->assertTrue(Auth::check());

        $this->assertRedirectedToRoute('rental.index');
    }

    public function testLoginBadCredentials()
    {
        $user = Factory::create('RentGorilla\User');

        $credentials = ['email' => $user->email, 'password' => 'bad pass'];

        $this->call('post', '/login', $credentials);

        $this->assertFalse(Auth::check());
    }

    public function testLoginWithAjax()
    {
        $user = Factory::create('RentGorilla\User');

        $credentials = ['email' => $user->email, 'password' => 'password'];

        $response = $this->call('post', '/login', $credentials, [], [], $this->ajaxRequest);

        $data = $response->getData();

        $this->assertTrue($data->success);

        $this->assertTrue(Auth::check());
    }

    public function testLoginWithAjaxBadCredentials()
    {
        $user = Factory::create('RentGorilla\User');

        $credentials = ['email' => $user->email, 'password' => 'bad pass'];

        $response = $this->call('post', '/login', $credentials, [], [], $this->ajaxRequest);

        $this->assertFalse(Auth::check());

        $data = $response->getData();

        $this->assertFalse($data->success);
    }

    public function testLogout()
    {
        $user = Factory::create('RentGorilla\User');

        Auth::loginUsingId($user->id);

        $this->call('get', '/logout');

        $this->assertFalse(Auth::check());
    }
}