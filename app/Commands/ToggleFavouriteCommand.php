<?php namespace RentGorilla\Commands;

use RentGorilla\Commands\Command;
use RentGorilla\User;

class ToggleFavouriteCommand extends Command {

    public $user_id;

    public $rental_id;

    function __construct($user_id, $rental_id)
    {
        $this->user_id = $user_id;
        $this->rental_id = $rental_id;
    }


}
