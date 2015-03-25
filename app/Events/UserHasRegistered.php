<?php namespace RentGorilla\Events;

use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Queue\InteractsWithQueue;
use RentGorilla\Events\Event;

use Illuminate\Queue\SerializesModels;
use RentGorilla\User;


class UserHasRegistered extends Event implements ShouldBeQueued {

	use SerializesModels;
    use InteractsWithQueue;

    public $user;

	public function __construct(User $user)
	{
        $this->user = $user;
    }

}
