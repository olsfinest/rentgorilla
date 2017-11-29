<?php

namespace RentGorilla\Handlers\Commands;

use Auth;
use Carbon\Carbon;
use RentGorilla\Repositories\RentalRepository;
use RentGorilla\Commands\ModifyRentalAvailabilityCommand;

class ModifyRentalAvailabilityCommandHandler
{
    /**
     * @var RentalRepository
     */
    protected $rentalRepository;

    /**
     * Create the command handler.
     *
     * @param RentalRepository $rentalRepository
     */
    public function __construct(RentalRepository $rentalRepository)
    {
        $this->rentalRepository = $rentalRepository;
    }

    /**
     * Handle the command.
     *
     * @param  ModifyRentalAvailabilityCommand  $command
     * @return boolean
     */
    public function handle(ModifyRentalAvailabilityCommand $command)
    {
        $rental = $this->rentalRepository->findRentalForUser(Auth::user(), $command->rental_id);

        $availabilityModified = false;

        switch ($command->request->get('date')) {
            case 'deactivate':
                $this->rentalRepository->deactivate($rental);
                $availabilityModified = false;
                break;
            case 'today':
                $rental->available_at = Carbon::today();
                $rental->save();
                $availabilityModified = true;
                break;
            case 'month':
                $rental->available_at = Carbon::today()->addDays(30);
                $rental->save();
                $availabilityModified = true;
                break;
            case 'year':
                $rental->available_at = Carbon::today()->addYear();
                $rental->save();
                $availabilityModified = true;
                break;
            case 'custom':
                $rental->available = $command->request->get('available');
                $rental->save();
                $availabilityModified = true;
                break;
        }

        return $availabilityModified;
    }
}
