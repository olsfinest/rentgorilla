<?php namespace RentGorilla\Rental;

use RentGorilla\Repositories\RentalRepository;
use RentGorilla\Mailers\UserMailer;
use RentGorilla\User;
use Log;

class RentalService
{
    /**
     * @var RentalRepository
     */
    protected $rentalRepository;
    /**
     * @var UserMailer
     */
    protected $mailer;

    /**
     * RentalService constructor.
     *
     * @param RentalRepository $rentalRepository
     * @param UserMailer $mailer
     */
    public function __construct(RentalRepository $rentalRepository, UserMailer $mailer)
    {
        $this->rentalRepository = $rentalRepository;
        $this->mailer = $mailer;
    }

    /**
     * Deactivate all rentals if not eligible for free plan.
     *
     * @param User $user
     */
    public function deactivateRentalsForUser(User $user)
    {
        if ($user->isEligibleForFreePlan()) {
            $this->downgradeToFreePlan($user);
        } else {
            $this->deactivateRentalsNow($user);
        }
    }

    /**
     * Downgrade given users rentals to free plan.
     *
     * @param User $user
     */
    public function downgradeToFreePlan(User $user)
    {
        if($this->userHasActiveRentals($user)) {
            $this->rentalRepository->downgradePlanCapacityForUser($user, 1);
            Log::info('User\'s active rentals downgraded to free plan after trial or subscription ended.', ['user_id' => $user->id]);
        }

        $this->mailer->sendDowngradedToFreePlan($user);
    }

    /**
     * Deactivate all a given users rentals.
     *
     * @param User $user
     */
    public function deactivateRentalsNow(User $user)
    {
        if($this->userHasActiveRentals($user)) {
            $this->rentalRepository->deactivateAllForUser($user);
            Log::info('User\'s active rentals deactivated after trial or subscription ended.', ['user_id' => $user->id]);
        }

        $this->mailer->sendRentalsDeactivated($user);
    }

    /**
     * Determine if a user has any active rentals.
     *
     * @param User $user
     * @return bool
     */
    private function userHasActiveRentals(User $user)
    {
        return $this->rentalRepository->getActiveRentalCountForUser($user) > 0;
    }
}