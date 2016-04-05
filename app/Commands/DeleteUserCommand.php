<?php

namespace RentGorilla\Commands;

use RentGorilla\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;

class DeleteUserCommand extends Command
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
}
