<?php

use Laracasts\TestDummy\DbTestCase;
use Laracasts\TestDummy\Factory;
use RentGorilla\User;

class RegistrationControllerTest extends DbTestCase {

    private $ajaxRequest = ['HTTP_X-Requested-With' => 'XMLHttpRequest'];
    private $ajaxContent = ['HTTP_CONTENT_TYPE' =>'application/json'];
    private $ajaxAccept = ['HTTP_ACCEPT', 'application/json'];



    public function testRegisterWithAjax()
    {
        $data = [
            'first_name' => 'Homer',
            'last_name' => 'Simpson',
            'email' => 'homer_simpson@springfieldpower.com',
            'password' => 12345678,
            'password_confirmation' => 12345678,
        ];

        $response = $this->call('post', '/register', $data, [], [], $this->ajaxRequest);

        $data = $response->getData();

        $this->assertTrue($data->success);

        $user = User::where('email', 'homer_simpson@springfieldpower.com')->first();

        $this->assertInstanceOf('RentGorilla\User', $user);
    }

    public function testConfirmation()
    {

        $user = Factory::create('RentGorilla\User', ['confirmed' => 0, 'email' => 'homer_simpson@springfieldpower.com']);

        $response = $this->call('get', "/register/confirm/{$user->confirmation}");

        $user = User::where('email', 'homer_simpson@springfieldpower.com')->first();

        $this->assertEquals(1, $user->confirmed);

        $this->assertTrue(Auth::check());
    }
}