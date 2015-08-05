<?php namespace RentGorilla\Commands;

use RentGorilla\Commands\Command;

class ToggleVideoLikeCommand extends Command {


    public $rental_id;
    public $user_id;

    function __construct($rental_id, $user_id)
    {
        $this->rental_id = $rental_id;
        $this->user_id = $user_id;
    }


}
