<?php namespace RentGorilla\Commands;

use RentGorilla\Commands\Command;

class SupportRequestCommand extends Command {

	public $user_id;
    public $question;

    function __construct($user_id, $question)
    {
        $this->user_id = $user_id;
        $this->question = $question;
    }


}
