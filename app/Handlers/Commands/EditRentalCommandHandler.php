<?php namespace RentGorilla\Handlers\Commands;

use Carbon\Carbon;
use Illuminate\Support\Str;
use RentGorilla\Commands\EditRentalCommand;

use Illuminate\Queue\InteractsWithQueue;
use RentGorilla\Repositories\LocationRepository;
use RentGorilla\Repositories\RentalRepository;
use Log;


class EditRentalCommandHandler {


    /**
     * @var RentalRepository
     */
    private $rentalRepository;
    /**
     * @var LocationRepository
     */
    private $locationRepository;

    function __construct(RentalRepository $rentalRepository, LocationRepository $locationRepository)
    {
        $this->rentalRepository = $rentalRepository;
        $this->locationRepository = $locationRepository;
    }

    public function handle(EditRentalCommand $command)
    {

        $rental = $this->rentalRepository->findByUUID($command->id);

        $rental->street_address = $command->street_address;
        $rental->location_id = $this->locationRepository->getLocation($command->city, $command->county, $command->province);
        $rental->postal_code = nullIfEmpty($command->postal_code);
        $rental->type = $command->type;
        $rental->pets = $command->pets;
        $rental->parking = $command->parking;
        $rental->baths = $command->baths;
        $rental->beds = $command->beds;
        $rental->price = $command->price;
        $rental->deposit = $command->deposit;
        $rental->laundry = $command->laundry;
        $rental->disability_access = $command->disability_access;
        $rental->smoking = $command->smoking;
        $rental->utilities_included = $command->utilities_included;
        $rental->heat_included = $command->heat_included;
        $rental->furnished = $command->furnished;
        $rental->square_footage = nullIfEmpty($command->square_footage);
        $rental->available = $command->available;
        $rental->lat = $command->lat;
        $rental->lng = $command->lng;
        $rental->lease = $command->lease;
        $rental->description = nullIfEmpty($command->description);
        $rental->video = nullIfEmpty($command->video);


        //they want to activate it
        if($command->active) {
            //if it wasn't already active, check if they are allowed to activate
            if( ! $rental->isActive()) {
                if($rental->user->canActivateRental()) {
                    $rental->active = 1;
                }
            }
            // do nothing since it was already active
        } else {
            //they want to deactivate it
            $rental->active = 0;
        }

        $rental->edited_at = Carbon::now();

        $rental->save();

        $features = is_null($command->feature_list) ? [] : $command->feature_list;
        $rental->features()->sync($features);

        $heats = is_null($command->heat_list) ? [] : $command->heat_list;
        $rental->heat()->sync($heats);

        $appliances = is_null($command->appliance_list) ? [] : $command->appliance_list;
        $rental->appliances()->sync($appliances);




        Log::info('Rental edited', ['rental_id' => $rental->id]);

        return $rental;
    }
}
