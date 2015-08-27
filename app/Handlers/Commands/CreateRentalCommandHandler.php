<?php namespace RentGorilla\Handlers\Commands;

use Carbon\Carbon;
use Hashids;
use RentGorilla\Commands\CreateRentalCommand;
use Illuminate\Queue\InteractsWithQueue;
use RentGorilla\Rental;
use RentGorilla\Repositories\LocationRepository;
use RentGorilla\Repositories\RentalRepository;
use Log;

class CreateRentalCommandHandler {


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

    public function handle(CreateRentalCommand $command)
	{
		$rental = new Rental();
        $rental->user_id = $command->user_id;
        $rental->location_id = $this->locationRepository->getLocation($command->city, $command->county, $command->province);
        $rental->street_address = $command->street_address;
        $rental->postal_code = nullIfEmpty($command->postal_code);
        $rental->type = $command->type;
        $rental->pets = $command->pets;
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

        $rental->edited_at = Carbon::now();

        $rental->save();

        //TODO::is there a more efficient way of doing this?
        $rental->uuid = Hashids::encode($rental->id);
        $rental->save();

        $heats = is_null($command->heat_list) ? [] : $command->heat_list;
        $rental->heat()->sync($heats);

        $appliances = is_null($command->appliance_list) ? [] : $command->appliance_list;
        $rental->appliances()->sync($appliances);

        $features = is_null($command->feature_list) ? [] : $command->feature_list;
        $rental->features()->sync($features);

        Log::info('New rental created', ['rental_id' => $rental->id]);

        return $rental;

    }

}
