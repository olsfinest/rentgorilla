<?php namespace RentGorilla\Commands;

use RentGorilla\Commands\Command;

class AdminNewUserCommand extends Command {

	public $first_name;
    public $last_name;
    public $email;
    public $is_admin;

    function __construct($first_name, $last_name, $email, $is_admin = null)
    {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->is_admin = $is_admin;
    }


}
