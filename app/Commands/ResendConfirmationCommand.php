<?php namespace RentGorilla\Commands;

use RentGorilla\Commands\Command;

class ResendConfirmationCommand extends Command
{

    public $email;

    function __construct($email)
    {
        $this->email = $email;
    }


}
