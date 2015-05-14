<?php namespace RentGorilla\Mailers;

use RentGorilla\Plans\Subscription;
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

        $this->sendTo($user, $subject, $view, $data);

    }

    public function sendSubscriptionCancelled(User $user)
    {
        $view = 'emails.user.cancel';
        $data = [
            'name' => $user->first_name,
            'planName' => Subscription::plan($user->getStripePlan())->planName(),
            'subscriptionEndsAt' => $user->getSubscriptionEndDate()->format('F jS, Y'),
            'daysFromNow' => $user->getSubscriptionEndDate()->diffForHumans()
        ];

        $subject = 'RentGorilla.ca :: Subscription cancelled';

        $this->sendTo($user, $subject, $view, $data);

    }

    public function sendSubscriptionBegun(User $user)
    {
        $plan = Subscription::plan($user->getStripePlan());

        $view = 'emails.user.subscription-begun';
        $data = [
            'name' => $user->first_name,
            'planName' => $plan->planName(),
            'maxListings' => $plan->maximumListings(),
            'interval' => $plan->interval()
        ];

        $subject = 'RentGorilla.ca :: Subscription begun';

        $this->sendTo($user, $subject, $view, $data);

    }

    public function sendSubscriptionResumed(User $user)
    {
        $plan = Subscription::plan($user->getStripePlan());

        $view = 'emails.user.subscription-resumed';

        $data = [
            'name' => $user->first_name,
            'planName' => $plan->planName(),
            'maxListings' => $plan->maximumListings(),
            'interval' => $plan->interval()
        ];

        $subject = 'RentGorilla.ca :: Subscription resumed';

        $this->sendTo($user, $subject, $view, $data);

    }

    public function sendSubscriptionChanged(User $user)
    {
        $plan = Subscription::plan($user->getStripePlan());

        $view = 'emails.user.subscription-changed';

        $data = [
            'name' => $user->first_name,
            'planName' => $plan->planName(),
            'maxListings' => $plan->maximumListings(),
            'interval' => $plan->interval()
        ];

        $subject = 'RentGorilla.ca :: Subscription changed';

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
            'address' => $rental->getAddress()
        ];

        $subject = 'RentGorilla.ca :: Your promotion has ended';

        $this->sendTo($user, $subject, $view, $data);
    }

    public function sendPromotionQueued(User $user, Rental $rental, $date)
    {
        $view = 'emails.user.promotion-queued';
        $data = [
            'first_name' => $user->first_name,
            'address' => $rental->getAddress(),
            'date' => $date->format('F jS, Y')
        ];

        $subject = 'RentGorilla.ca :: Your promotion has been queued!';

        $this->sendTo($user, $subject, $view, $data);
    }

    public function sendPromotionChargeFailed(User $user, Rental $rental)
    {
        $view = 'emails.user.promotion-charge-failed';
        $data = [
            'first_name' => $user->first_name,
            'address' => $rental->getAddress()
        ];

        $subject = 'RentGorilla.ca :: Charge failed';

        $this->sendTo($user, $subject, $view, $data);
    }

    public function sendContactManager(User $user, Rental $rental, $fname, $lname, $message, $email)
    {
        $view = 'emails.user.contact-manager';

        $name = $fname . ' ' . $lname;

        $data = [
            'first_name' => $user->first_name,
            'address' => $rental->getAddress(),
            'name' => $name,
            'email' => $email,
            'the_message' => $message,
        ];

        $subject = 'RentGorilla.ca :: Inquiry regarding ' . $rental->getAddress();

        return $this->sendToUserWithReplyTo($user, $subject, $view, $data, $email, $name);
    }

    public function sendAchievementAwarded(User $user, $achievement, $points)
    {
        $view = 'emails.user.achievement-awarded';

        $data = [
            'first_name' => $user->first_name,
            'achievement' => $achievement,
            'points' => $points,
            'total' => $user->points
        ];

        $subject = 'RentGorilla.ca :: Achievement Awarded';

        $this->sendTo($user, $subject, $view, $data);
    }


    public function sendRentalsDeactivated(User $user)
    {
        $view = 'emails.user.rentals-deactivated';

        $data = [
            'first_name' => $user->first_name,
        ];

        $subject = 'RentGorilla.ca :: Rentals Deactivated';

        $this->sendTo($user, $subject, $view, $data);
    }



}

