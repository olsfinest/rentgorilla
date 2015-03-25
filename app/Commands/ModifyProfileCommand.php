<?php namespace RentGorilla\Commands;

use RentGorilla\Commands\Command;

class ModifyProfileCommand extends Command
{

    public $user_id;
    public $primary_phone;
    public $alternate_phone;
    public $website;
    public $bio;

    function __construct($user_id, $primary_phone, $alternate_phone, $website, $bio)
    {
        $this->user_id = $user_id;
        $this->primary_phone = $primary_phone;
        $this->alternate_phone = $alternate_phone;
        $this->website = $website;
        $this->bio = $bio;
    }


}
