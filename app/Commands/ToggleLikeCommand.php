<?php namespace RentGorilla\Commands;

use RentGorilla\Commands\Command;

class ToggleLikeCommand extends Command {

	public $user_id;
    public $rental_id;
    public $photo_id;

    function __construct($user_id, $rental_id, $photo_id)
    {
        $this->user_id = $user_id;
        $this->rental_id = $rental_id;
        $this->photo_id = $photo_id;
    }


}
