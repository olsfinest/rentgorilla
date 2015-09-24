<?php namespace RentGorilla\MailingList;

use Mailchimp\Mailchimp;
use RentGorilla\User;

class MailChimpMailingList implements MailingList
{

    const LIST_ID = '8a399bf397';

    /**
     * @var Mailchimp
     */
    protected $mailchimp;

    public function __construct()
    {
        $this->mailchimp = new Mailchimp(config('mailchimp.apikey'));
    }

    public function addUserToList(User $user)
    {
        return $this->mailchimp->post('lists/' . self::LIST_ID . '/members', ['email_address' => $user->email,
            'status' => 'subscribed',
            'merge_fields' => [
                'FNAME' => $user->first_name,
                'LNAME' => $user->last_name
            ]]);
    }

    public function removeUserFromList(User $user)
    {
        return $this->mailchimp->patch('lists/' . self::LIST_ID . '/members/'. md5($user->email), ['status' => 'unsubscribed']);
    }
}