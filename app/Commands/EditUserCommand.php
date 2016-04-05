<?php

namespace RentGorilla\Commands;

use RentGorilla\Commands\Command;

class EditUserCommand extends Command
{
    /**
     * @var
     */
    public $id;
    /**
     * @var
     */
    public $first_name;
    /**
     * @var
     */
    public $last_name;
    /**
     * @var
     */
    public $email;

    public function __construct($id, $first_name, $last_name, $email)
    {
        $this->id = $id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
    }
}
