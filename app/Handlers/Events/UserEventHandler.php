<?php namespace RentGorilla\Handlers\Events;

use RentGorilla\MailingList\MailChimpMailingList;
use RentGorilla\Events\UserHasBeenDeleted;
use RentGorilla\Events\UserHasRegistered;
use RentGorilla\Events\UserHasConfirmed;
use RentGorilla\Events\UserInfoChanged;
use RentGorilla\Mailers\UserMailer;
use RentGorilla\Billing\Biller;
use Log;

class UserEventHandler {

    protected $userMailer;
    protected $mailingList;
    protected $biller;

    function __construct(UserMailer $userMailer, MailChimpMailingList $mailingList, Biller $biller)
    {
        $this->userMailer = $userMailer;
        $this->mailingList = $mailingList;
        $this->biller = $biller;
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

        if(app()->environment() === 'production') {
            $this->mailingList->addUserToList($event->user);
        }
    }

    public function onUserHasBeenDeleted(UserHasBeenDeleted $event)
    {
        if(app()->environment() === 'production') {
            $this->mailingList->removeUserFromList($event->user);
            $this->biller->deleteAccount($event->user);
        }
    }

    public function onUserInfoChanged(UserInfoChanged $event)
    {
        if(app()->environment() === 'production') {
            $this->mailingList->updateUser($event->old_email, $event->user);
            $this->biller->updateEmail($event->user);
        }
    }

    public function subscribe($events)
    {
        $events->listen(UserHasRegistered::class, 'RentGorilla\Handlers\Events\UserEventHandler@onUserHasRegistered');
        $events->listen(UserHasConfirmed::class, 'RentGorilla\Handlers\Events\UserEventHandler@onUserHasConfirmed');
        $events->listen(UserHasBeenDeleted::class, 'RentGorilla\Handlers\Events\UserEventHandler@onUserHasBeenDeleted');
        $events->listen(UserInfoChanged::class, 'RentGorilla\Handlers\Events\UserEventHandler@onUserInfoChanged');
    }
}