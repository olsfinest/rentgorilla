<?php namespace RentGorilla\Handlers\Commands;

use Carbon\Carbon;
use Illuminate\Support\Str;
use RentGorilla\Commands\EditRentalCommand;

use Illuminate\Queue\InteractsWithQueue;
use RentGorilla\Repositories\RentalRepository;
use Log;


class EditRentalCommandHandler {


    /**
     * @var RentalRepository
     */
    private $rentalRepository;

    function __construct(RentalRepository $rentalRepository)
    {
        $this->rentalRepository = $rentalRepository;
    }

    public function handle(EditRentalCommand $command)
    {
        $rental = $this->rentalRepository->findByUUID($command->id);

        $rental->street_address = $command->street_address;

        if($command->county && $this->rentalRepository->cityIsDuplicate($command->city, $command->county, $command->province)) {
            $rental->city = $command->city . ', ' . $command->county;
        } else {
            $rental->city = $command->city;
        }

        $rental->county = nullIfEmpty($command->county);
        $rental->province = $command->province;
        $rental->location = Str::slug($rental->city . '-' . $command->province);
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
        $rental->square_footage = $command->square_footage;
        $rental->available = $command->available;
        $rental->lat = $command->lat;
        $rental->lng = $command->lng;
        $rental->lease = $command->lease;
        $rental->description = nullIfEmpty($command->description);
        $rental->video = nullIfEmpty($command->video);

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
