<?php

namespace RentGorilla\Commands;

use RentGorilla\Commands\Command;

class CreateAreaCommand extends Command
{
    public $name;
    public $province;

    public function __construct($name, $province)
    {
        $this->name = $name;
        $this->province = $province;
    }
}
