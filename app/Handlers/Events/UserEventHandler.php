<?php namespace RentGorilla\Handlers\Events;

use RentGorilla\Events\UserHasRegistered;
use RentGorilla\Mailers\UserMailer;

class UserEventHandler {

    protected $userMailer;

    function __construct(UserMailer $userMailer)
    {
        $this->userMailer = $userMailer;
    }

    public function onUserHasRegistered(UserHasRegistered $event)
    {
        $this->userMailer->sendConfirmation($event->user);
    }

    public function subscribe($events)
    {
        $events->listen(UserHasRegistered::class, 'RentGorilla\Handlers\Events\UserEventHandler@onUserHasRegistered');
    }

}