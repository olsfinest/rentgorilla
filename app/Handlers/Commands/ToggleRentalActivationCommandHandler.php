<?php namespace RentGorilla\Handlers\Commands;

use RentGorilla\Commands\ToggleRentalActivationCommand;
use Illuminate\Queue\InteractsWithQueue;
use RentGorilla\Repositories\RentalRepository;

class ToggleRentalActivationCommandHandler
{

    const SUBSCRIPTION_NEEDED = 'You need a subscription to activate more than one property.';
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
        $rental = $this->rentalRepository->find($command->rental_id);

        if($rental->isActive()) {

            $this->rentalRepository->deactivate($command->rental_id);

            return false;

        } else {

            // user can activate a rental if they are subscribed or if they have no active rentals

            if ($rental->user->subscribed() || $this->rentalRepository->getActiveRentalCountForUser($rental->user) === 0) {

                $this->rentalRepository->activate($command->rental_id);

                return true;

            } else {

                return self::SUBSCRIPTION_NEEDED;

            }
        }
    }
}
