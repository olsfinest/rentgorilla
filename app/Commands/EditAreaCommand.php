<?php

namespace RentGorilla\Commands;

use RentGorilla\Commands\Command;

class EditAreaCommand extends Command
{

    public $id;
    public $name;
    public $province;

    public function __construct($id, $name, $province)
    {
        $this->id = $id;
        $this->name = $name;
        $this->province = $province;
    }
}
