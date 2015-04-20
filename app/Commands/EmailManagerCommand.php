<?php namespace RentGorilla\Commands;

use RentGorilla\Commands\Command;

class EmailManagerCommand extends Command {

	public $fname;
    public $lname;
    public $email;
    public $message;
    public $rental_id;

    function __construct($fname, $lname, $email, $message, $rental_id)
    {
        $this->fname = $fname;
        $this->lname = $lname;
        $this->email = $email;
        $this->message = $message;
        $this->rental_id = $rental_id;
    }


}
