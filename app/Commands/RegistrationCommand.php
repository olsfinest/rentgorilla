<?php namespace RentGorilla\Commands;

use RentGorilla\Commands\Command;

class RegistrationCommand extends Command {

	public $first_name;

    public $last_name;

    public $email;

    public $password;

    public $user_type;

    function __construct($first_name, $last_name, $email, $password, $user_type)
    {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->password = $password;
        $this->user_type = $user_type;
    }

}
