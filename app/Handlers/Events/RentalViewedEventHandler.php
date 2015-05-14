<?php namespace RentGorilla\Handlers\Events;

use Illuminate\Session\Store;
use RentGorilla\Events\RentalViewed;

use RentGorilla\Rental;
use RentGorilla\Repositories\RentalRepository;

class RentalViewedEventHandler {

    protected $session;
    /**
     * @var RentalRepository
     */
    protected $rentalRepository;

    public function __construct(Store $session, RentalRepository $rentalRepository)
    {
        $this->session = $session;
        $this->rentalRepository = $rentalRepository;
    }

    public function handle(RentalViewed $event)
    {

        $rental = $this->rentalRepository->find($event->rental_id);

        if ( ! $this->hasViewedRental($rental)) {
            $this->rentalRepository->incrementViews($rental);
            $this->storeViewedRental($rental);
        }
    }

    protected function hasViewedRental(Rental $rental)
    {
        return array_key_exists($rental->id, $this->getViewedRentals());
    }

    /**
     * Get the users viewed post from the session.
     *
     * @return array
     */
    protected function getViewedRentals()
    {
        return $this->session->get('viewed_rentals', []);
    }


    protected function storeViewedRental(Rental $rental)
    {
        $key = 'viewed_rentals.' . $rental->id;
        $this->session->put($key, time());
    }
}
