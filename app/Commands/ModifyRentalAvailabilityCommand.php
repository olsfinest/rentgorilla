<?php

namespace RentGorilla\Commands;

use RentGorilla\Commands\Command;

class ModifyRentalAvailabilityCommand extends Command
{
    public $request;
    public $rental_id;

    function __construct($request, $rental_id)
    {
        $this->request = $request;
        $this->rental_id = $rental_id;
    }
}
