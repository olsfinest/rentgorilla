<?php namespace RentGorilla\Handlers\Commands;

use RentGorilla\Commands\ToggleRentalActivationCommand;
use Illuminate\Queue\InteractsWithQueue;
use RentGorilla\Plans\Subscription;
use RentGorilla\Repositories\RentalRepository;

class ToggleRentalActivationCommandHandler
{

    const SUBSCRIPTION_NEEDED = 'Please upgrade your subscription to activate more properties.';
    /**
     * @var RentalRepository
     */
    private $rentalRepository;

    public function __construct(RentalRepository $rentalRepository)
    {
        $this->rentalRepository = $rentalRepository;
    }

    /**
     * Handle the command.
     *
     * @param  ToggleRentalActivationCommand  $command
     * @return void
     */
    public function handle(ToggleRentalActivationCommand $command)
    {
        $rental = $this->rentalRepository->findByUUID($command->rental_id);

        if($rental->isActive()) {

            $this->rentalRepository->deactivate($rental);

            return false;

        } else {

            if ($rental->user->onTrial() || $this->rentalRepository->getActiveRentalCountForUser($rental->user) === 0) {

                $this->rentalRepository->activate($rental);

                return true;

            } else if ($rental->user->subscribed() && ($this->rentalRepository->getActiveRentalCountForUser($rental->user) < Subscription::plan($rental->user->getStripePlan())->maximumListings() || Subscription::plan($rental->user->getStripePlan())->unlimited())) {

                $this->rentalRepository->activate($rental);

                return true;

            } else {

                return self::SUBSCRIPTION_NEEDED;

            }
        }
    }
}
