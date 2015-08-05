<?php namespace RentGorilla\Events;

use RentGorilla\Events\Event;

use Illuminate\Queue\SerializesModels;

class SearchWasInitiated extends Event
{

    use SerializesModels;

    public $rentalIds;

    function __construct($rentalIds)
    {
        $this->rentalIds = $rentalIds;
    }
}
