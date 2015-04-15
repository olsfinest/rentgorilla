<?php namespace RentGorilla\Handlers\Commands;

use RentGorilla\Commands\EditRentalCommand;

use Illuminate\Queue\InteractsWithQueue;
use RentGorilla\Repositories\RentalRepository;

class EditRentalCommandHandler {


    /**
     * @var RentalRepository
     */
    protected $rentalRepository;

    function __construct(RentalRepository $rentalRepository)
    {
        $this->rentalRepository = $rentalRepository;
    }

    public function handle(EditRentalCommand $command)
    {
        $rental = $this->rentalRepository->findByUUID($command->id);

        $rental->street_address = $command->street_address;
        $rental->city = $command->city;
        $rental->province = $command->province;
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
        $rental->square_footage = $command->square_footage;
        $rental->available = $command->available;
        $rental->lat = $command->lat;
        $rental->lng = $command->lng;
        $rental->lease = $command->lease;
        $rental->description = $command->description;

        $rental->save();

        $features = is_null($command->feature_list) ? [] : $command->feature_list;
        $rental->features()->sync($features);

        $heats = is_null($command->heat_list) ? [] : $command->heat_list;
        $rental->heat()->sync($heats);

        $appliances = is_null($command->appliance_list) ? [] : $command->appliance_list;
        $rental->appliances()->sync($appliances);

        return $rental;
    }
}
