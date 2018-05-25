<?php namespace RentGorilla\Rental;

use RentGorilla\Repositories\RentalRepository;
use RentGorilla\Mailers\UserMailer;
use RentGorilla\Plans\Plan;
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
        $this->rentalRepository->deactivateAllForUser($user);
        Log::info('User\'s active rentals deactivated after subscription ended.', ['user_id' => $user->id]);
        $this->mailer->sendRentalsDeactivated($user);
    }

    /**
     * Deactivate all a given users rentals.
     *
     * @param User $user
     */
    public function deactivateTrialNow(User $user)
    {
        $activeRentalCount = $this->rentalRepository->getActiveRentalCountForUser($user);

        if($activeRentalCount) {
            if(! $user->subscribed()) {
                $this->rentalRepository->deactivateAllForUser($user);
            }
            if($user->subscribed() && $this->usingFreeRental($user, $activeRentalCount)) {
                $this->rentalRepository->downgradePlanCapacityForUser($user, $user->plan()->maximumListings());
            }
        }

        $this->mailer->sendFreeTrialOver($user);
        Log::info('User\'s free trial ended.', ['user_id' => $user->id]);
    }

    public function enforceActiveRentalsCountOnSubscribe(User $user, Plan $plan)
    {
        $activeRentalCount = $this->rentalRepository->getActiveRentalCountForUser($user);

        $isDowngrade = false;
        $difference = 0;

        if($activeRentalCount) {
            if( ! $plan->unlimited() && $activeRentalCount > $plan->maximumListings()) {
                $difference = $activeRentalCount - $plan->maximumListings();
                $isDowngrade = true;
                if($user->isEligibleForFreePlan()) {
                    $this->rentalRepository->downgradePlanCapacityForUser($user, $plan->maximumListings() + 1);
                } else {
                    $this->rentalRepository->downgradePlanCapacityForUser($user, $plan->maximumListings());
                }
            }
        }

        return [$isDowngrade, $difference];
    }

    public function enforceActiveRentalsCountOnSwap(User $user, Plan $newPlan, $isDowngrade = false)
    {
        $difference = 0;
        if($isDowngrade) {

            $activeRentalCount = $this->rentalRepository->getActiveRentalCountForUser($user);

            if($activeRentalCount) {
                if( ! $newPlan->unlimited() && ($activeRentalCount > $newPlan->maximumListings())) {
                    $difference = $activeRentalCount - $newPlan->maximumListings();
                    if($user->isEligibleForFreePlan()) {
                        $this->rentalRepository->downgradePlanCapacityForUser($user, $newPlan->maximumListings() + 1);
                    } else {
                        $this->rentalRepository->downgradePlanCapacityForUser($user, $newPlan->maximumListings());
                    }
                }
            }
        }

        return [$isDowngrade, $difference];
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

    /**
     * @param User $user
     * @param $activeRentalCount
     * @return bool
     */
    private function usingFreeRental(User $user, $activeRentalCount)
    {
        return $activeRentalCount > $user->plan()->maximumListings();
    }
}