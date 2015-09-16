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

            Log::info('deactivated rental in repo');

            return false;

        } else {


            if($rental->user->canActivateRental())
            {
                $this->rentalRepository->activate($rental);
                Log::info('activated rental in repo');
                return true;
            }

            Log::info('sub needed');

            return self::SUBSCRIPTION_NEEDED;

        }
    }
}
