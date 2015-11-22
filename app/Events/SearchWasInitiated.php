<?php namespace RentGorilla\Events;

use RentGorilla\Events\Event;


class SearchWasInitiated extends Event
{

    public $rentalIds;
    public $locationId;

    function __construct($rentalIds, $locationId = null)
    {
        $this->rentalIds = $rentalIds;
        $this->locationId = $locationId;
    }
}
