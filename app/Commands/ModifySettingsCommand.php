<?php namespace RentGorilla\Commands;

use RentGorilla\Commands\Command;

class ModifySettingsCommand extends Command {

	public $user_id;
    public $monthly_emails;

    function __construct($user_id, $monthly_emails = null)
    {
        $this->user_id = $user_id;
        $this->monthly_emails = $monthly_emails;
    }


}
