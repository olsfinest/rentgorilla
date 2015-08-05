<?php namespace RentGorilla\Events;

use RentGorilla\Events\Event;
use RentGorilla\User;


class UserHasRegistered extends Event {


    public $user;

	public function __construct(User $user)
	{
        $this->user = $user;
    }

}
