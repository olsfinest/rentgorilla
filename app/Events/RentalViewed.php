<?php namespace RentGorilla\Events;

use RentGorilla\Events\Event;

use Illuminate\Queue\SerializesModels;

class RentalViewed extends Event {

	use SerializesModels;

	public $rental_id;

    function __construct($rental_id)
    {
        $this->rental_id = $rental_id;
    }


}
