<?php namespace RentGorilla\MailingList;

use Log;
use RentGorilla\User;
use Mailchimp\Mailchimp;

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
        try {
            $response = $this->mailchimp->post('lists/' . self::LIST_ID . '/members', [
                'email_address' => $user->email,
                'status' => 'subscribed',
                'merge_fields' => [
                    'FNAME' => $user->first_name,
                    'LNAME' => $user->last_name
                ]
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $response = null;
        }

        return $response;
    }

    public function removeUserFromList(User $user)
    {
        try {
            $response = $this->mailchimp->patch('lists/' . self::LIST_ID . '/members/' . md5($user->email),
                ['status' => 'unsubscribed']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $response = null;
        }

        return $response;
    }

    public function updateUser($old_email, User $user)
    {
        try {
            $response = $this->mailchimp->patch('lists/' . self::LIST_ID . '/members/'. md5($old_email), ['email_address' => $user->email,
            'status' => 'subscribed',
            'merge_fields' => [
                'FNAME' => $user->first_name ? $user->first_name : '',
                'LNAME' => $user->last_name ? $user->last_name : ''
            ]]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $response = null;
        }

        return $response;
    }
}