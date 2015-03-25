<?php namespace RentGorilla\Mailers;

use RentGorilla\User;

class UserMailer extends Mailer {

    public function sendWelcome(User $user)
    {
        $view = 'emails.user.welcome';
        $data = [
            'name' => $user->first_name
        ];
        $subject = 'Welcome to MaritmeMarkets.ca, ' . $user->first_name . '!';

        //TODO: make body of welcome email

        $this->sendTo($user, $subject, $view, $data);
    }

    public function sendCancellation(User $user)
    {
        $view = 'emails.user.cancel';
        $data = [];
        $subject = 'Sorry to see you go';

        $this->sendTo($user, $subject, $view, $data);

    }

    public function sendConfirmation(User $user)
    {

        $view = 'emails.user.confirm';
        $data = [
            'first_name' => $user->first_name,
            'url_token' => $user->confirmation
        ];
        $subject = 'MaritimeMarkets.ca :: Please confirm your registration';

        $this->sendTo($user, $subject, $view, $data);

    }


}

