<?php namespace RentGorilla\Commands;

use RentGorilla\Commands\Command;

class ModifyProfileCommand extends Command
{

    public $user_id;
    public $primary_phone;
    public $website;
    public $bio;
    public $photo;
    public $first_name;
    public $last_name;
    public $company;
    public $accepts_texts;


    function __construct($user_id, $primary_phone, $website, $bio, $photo, $first_name, $last_name, $company, $accepts_texts = null)
    {
        $this->user_id = $user_id;
        $this->primary_phone = $primary_phone;
        $this->website = $website;
        $this->bio = $bio;
        $this->photo = $photo;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->company = $company;
        $this->accepts_texts = $accepts_texts;
    }
}
