<?php namespace RentGorilla\Commands;

use RentGorilla\Commands\Command;

class ConfirmEmailCommand extends Command {


    public $token;

	public function __construct($token)
	{
        $this->token = $token;
    }

}
