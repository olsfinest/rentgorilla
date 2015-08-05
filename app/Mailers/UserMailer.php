<?php namespace RentGorilla\Mailers;

use Subscription;
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

        return $this->sendTo($user, $subject, $view, $data);

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

        return $this->sendTo($user, $subject, $view, $data);

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

        return $this->sendTo($user, $subject, $view, $data);

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

        return $this->sendTo($user, $subject, $view, $data);

    }

    public function sendSubscriptionChanged(User $user, $isDownGrade)
    {
        $plan = Subscription::plan($user->getStripePlan());

        $view = 'emails.user.subscription-changed';

        $data = [
            'name' => $user->first_name,
            'planName' => $plan->planName(),
            'maxListings' => $plan->maximumListings(),
            'interval' => $plan->interval(),
            'isDowngrade' => $isDownGrade
        ];

        $subject = 'RentGorilla.ca :: Subscription changed';

        return $this->sendTo($user, $subject, $view, $data);

    }


    public function sendConfirmation(User $user)
    {

        $view = 'emails.user.confirm';
        $data = [
            'name' => $user->first_name,
            'url_token' => $user->confirmation
        ];
        $subject = 'RentGorilla.ca :: Please confirm your registration';

        return $this->sendTo($user, $subject, $view, $data);

    }

    public function sendPromotionStart(User $user, Rental $rental)
    {
        $view = 'emails.user.promotion-start';
        $data = [
            'name' => $user->first_name,
            'address' => $rental->street_address
        ];

        $subject = 'RentGorilla.ca :: Your promotion has begun!';

        return $this->sendTo($user, $subject, $view, $data);
    }

    public function sendPromotionEnded(User $user, Rental $rental)
    {
        $view = 'emails.user.promotion-end';
        $data = [
            'name' => $user->first_name,
            'address' => $rental->getAddress()
        ];

        $subject = 'RentGorilla.ca :: Your promotion has ended';

        return $this->sendTo($user, $subject, $view, $data);
    }

    public function sendPromotionQueued(User $user, Rental $rental, $date)
    {
        $view = 'emails.user.promotion-queued';
        $data = [
            'name' => $user->first_name,
            'address' => $rental->getAddress(),
            'date' => $date->format('F jS, Y')
        ];

        $subject = 'RentGorilla.ca :: Your promotion has been queued!';

        return $this->sendTo($user, $subject, $view, $data);
    }

    public function sendPromotionChargeFailed(User $user, Rental $rental)
    {
        $view = 'emails.user.promotion-charge-failed';
        $data = [
            'name' => $user->first_name,
            'address' => $rental->getAddress()
        ];

        $subject = 'RentGorilla.ca :: Charge failed';

        return $this->sendTo($user, $subject, $view, $data);
    }

    public function sendContactManager(User $user, Rental $rental, $fname, $lname, $message, $email)
    {
        $view = 'emails.user.contact-manager';

        $name = $fname . ' ' . $lname;

        $data = [
            'name' => $user->first_name,
            'address' => $rental->getAddress(),
            'the_name' => $name,
            'the_email' => $email,
            'the_message' => $message,
        ];

        $subject = 'RentGorilla.ca :: Inquiry regarding ' . $rental->getAddress();

        return $this->sendToUserWithReplyTo($user, $subject, $view, $data, $email, $name);
    }

    public function sendAchievementAwarded(User $user, $achievement, $points)
    {
        $view = 'emails.user.achievement-awarded';

        $data = [
            'name' => $user->first_name,
            'achievement' => $achievement,
            'points' => $points,
            'total' => $user->points
        ];

        $subject = 'RentGorilla.ca :: Achievement Awarded';

        return $this->sendTo($user, $subject, $view, $data);
    }


    public function sendRentalsDeactivated(User $user)
    {
        $view = 'emails.user.rentals-deactivated';

        $data = [
            'name' => $user->first_name,
        ];

        $subject = 'RentGorilla.ca :: Plan Expired';

        return $this->sendTo($user, $subject, $view, $data);
    }

    public function sendDowngradedToFreePlan(User $user)
    {
        $view = 'emails.user.downgraded-free-plan';

        $data = [
            'name' => $user->first_name,
        ];

        $subject = 'RentGorilla.ca :: Plan Expired';

        return $this->sendTo($user, $subject, $view, $data);
    }

    public function sendPointsRedeemed(User $user, $redeemedPoints, $credit)
    {
        $view = 'emails.user.points-redeemed';

        $data = [
            'name' => $user->first_name,
            'redeemedPoints' => $redeemedPoints,
            'currentPoints' => $user->points,
            'credit' => $credit
        ];

        $subject = 'RentGorilla.ca :: Plan Expired';

        return $this->sendTo($user, $subject, $view, $data);
    }

    public function sendFailedSubscriptionPayment(User $user)
    {
        $view = 'emails.user.failed-subscription-payment';

        $data = [
            'name' => $user->first_name
        ];

        $subject = 'RentGorilla.ca :: Subscription Payment Failed';

        return $this->sendTo($user, $subject, $view, $data);
    }

    public function sendPasswordResetToNewUser(User $user, $token)
    {
        $view = 'emails.user.password-reset-new-user';

        $data = [
            'name' => $user->first_name,
            'token' => $token
        ];

        $subject = 'RentGorilla.ca :: Welcome to RentGorilla.ca';

        return $this->sendTo($user, $subject, $view, $data);
    }

    public function sendReportToAllUsers()
    {
        $view = 'emails.user.property-report';
        $subject = 'RentGorilla.ca :: Property Report';

        User::where('monthly_emails', 1)->chunk(100, function($users) use ($view, $subject)
        {
            foreach ($users as $user)
            {
                 $data = [
                    'name' => $user->first_name,
                ];

                //TODO::finish email template

                //$this->sendTo($user, $subject, $view, $data);
            }
        });
    }

    public function sendTest($user)
    {
        $view = 'emails.user.test';


        $subject = 'RentGorilla.ca :: test';

        return $this->sendTo($user, $subject, $view, []);
    }
}