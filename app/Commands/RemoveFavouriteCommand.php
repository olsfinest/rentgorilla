<?php namespace RentGorilla\Commands;

use RentGorilla\Commands\Command;

class RemoveFavouriteCommand extends Command {

    public $rental_id;

    function __construct($rental_id)
    {
        $this->rental_id = $rental_id;
    }


}
