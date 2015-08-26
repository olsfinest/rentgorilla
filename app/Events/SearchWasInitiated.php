<?php namespace RentGorilla\Events;

use RentGorilla\Events\Event;


class SearchWasInitiated extends Event
{

    public $rentalIds;

    function __construct($rentalIds)
    {
        $this->rentalIds = $rentalIds;
    }
}
