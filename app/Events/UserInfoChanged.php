<?php

namespace RentGorilla\Events;

use RentGorilla\User;
use RentGorilla\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserInfoChanged extends Event
{
    use SerializesModels;
    /**
     * @var
     */
    public $old_email;
    /**
     * @var User
     */
    public $user;

    public function __construct($old_email, User $user)
    {
        $this->old_email = $old_email;
        $this->user = $user;
    }
}
