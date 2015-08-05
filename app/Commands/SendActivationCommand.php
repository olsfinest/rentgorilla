<?php namespace RentGorilla\Commands;

use RentGorilla\Commands\Command;

class SendActivationCommand extends Command {

	public $user_id;

    function __construct($user_id)
    {
        $this->user_id = $user_id;
    }


}
