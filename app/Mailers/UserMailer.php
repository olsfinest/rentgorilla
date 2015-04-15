<?php namespace RentGorilla\Mailers;

use RentGorilla\Rental;
use RentGorilla\User;

class UserMailer extends Mailer {

    public function sendWelcome(User $user)
    {
        $view = 'emails.user.welcome';
        $data = [
            'name' => $user->first_name
        ];
        $subject = 'Welcome to RentGorilla.ca, ' . $user->first_name . '!';

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
        $subject = 'RentGorilla.ca :: Please confirm your registration';

        $this->sendTo($user, $subject, $view, $data);

    }

    public function sendPromotionStart(User $user, Rental $rental)
    {
        $view = 'emails.user.promotion-start';
        $data = [
            'first_name' => $user->first_name,
            'address' => $rental->street_address
        ];

        $subject = 'RentGorilla.ca :: Your promotion has begun!';

        $this->sendTo($user, $subject, $view, $data);
    }

    public function sendPromotionEnded(User $user, Rental $rental)
    {
        $view = 'emails.user.promotion-end';
        $data = [
            'first_name' => $user->first_name,
            'address' => $rental->street_address
        ];

        $subject = 'RentGorilla.ca :: Your promotion has ended';

        $this->sendTo($user, $subject, $view, $data);
    }

    public function sendPromotionQueued(User $user, Rental $rental, $date)
    {
        $view = 'emails.user.promotion-queued';
        $data = [
            'first_name' => $user->first_name,
            'address' => $rental->street_address,
            'date' => $date->format('F jS, Y')
        ];

        $subject = 'RentGorilla.ca :: Your promotion has been queued!';

        $this->sendTo($user, $subject, $view, $data);
    }

}

