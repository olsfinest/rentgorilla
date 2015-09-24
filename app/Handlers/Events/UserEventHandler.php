<?php namespace RentGorilla\Handlers\Events;

use RentGorilla\Events\UserHasBeenDeleted;
use RentGorilla\Events\UserHasConfirmed;
use RentGorilla\Events\UserHasRegistered;
use RentGorilla\Mailers\UserMailer;
use Log;
use RentGorilla\MailingList\MailChimpMailingList;

class UserEventHandler {

    protected $userMailer;
    /**
     * @var MailingList
     */
    protected $mailingList;

    function __construct(UserMailer $userMailer, MailChimpMailingList $mailingList)
    {
        $this->userMailer = $userMailer;
        $this->mailingList = $mailingList;
    }

    public function onUserHasRegistered(UserHasRegistered $event)
    {
        Log::info('User has registered via email but not confirmed', ['id' => $event->user->id]);
        $this->userMailer->sendConfirmation($event->user);
    }

    public function onUserHasConfirmed(UserHasConfirmed $event)
    {
        Log::info('User has confirmed their email address', ['id' => $event->user->id]);
        $this->userMailer->sendWelcome($event->user);
        $this->mailingList->addUserToList($event->user);
    }

    public function onUserHasBeenDeleted(UserHasBeenDeleted $event)
    {
        $this->mailingList->removeUserFromList($event->user);
    }

    public function subscribe($events)
    {
        $events->listen(UserHasRegistered::class, 'RentGorilla\Handlers\Events\UserEventHandler@onUserHasRegistered');
        $events->listen(UserHasConfirmed::class, 'RentGorilla\Handlers\Events\UserEventHandler@onUserHasConfirmed');
        $events->listen(UserHasBeenDeleted::class, 'RentGorilla\Handlers\Events\UserEventHandler@onUserHasBeenDeleted');
    }

}