<?php namespace RentGorilla\Handlers\Events;

use RentGorilla\Events\UserHasConfirmed;
use RentGorilla\Events\UserHasRegistered;
use RentGorilla\Mailers\UserMailer;
use Log;

class UserEventHandler {

    protected $userMailer;

    function __construct(UserMailer $userMailer)
    {
        $this->userMailer = $userMailer;
    }

    public function onUserHasRegistered(UserHasRegistered $event)
    {
        Log::info('User has registered but not confirmed', ['user_id' => $event->user->id]);
        $this->userMailer->sendConfirmation($event->user);
    }

    public function onUserHasConfirmed(UserHasConfirmed $event)
    {
        Log::info('User has confirmed their email address', ['user_id' => $event->user->id]);
        $this->userMailer->sendWelcome($event->user);
    }

    public function subscribe($events)
    {
        $events->listen(UserHasRegistered::class, 'RentGorilla\Handlers\Events\UserEventHandler@onUserHasRegistered');
        $events->listen(UserHasConfirmed::class, 'RentGorilla\Handlers\Events\UserEventHandler@onUserHasConfirmed');

    }

}