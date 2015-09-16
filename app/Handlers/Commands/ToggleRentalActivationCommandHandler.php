<?php namespace RentGorilla\Handlers\Commands;

use RentGorilla\Commands\ToggleRentalActivationCommand;
use Illuminate\Queue\InteractsWithQueue;
use Subscription;
use RentGorilla\Repositories\RentalRepository;
use Log;

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


            if($rental->user->canActivateRental())
            {
                $this->rentalRepository->activate($rental);
                return true;
            }

            return self::SUBSCRIPTION_NEEDED;

        }
    }
}
