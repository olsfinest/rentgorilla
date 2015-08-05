<?php namespace RentGorilla\Handlers\Events;

use RentGorilla\Events\SearchWasInitiated;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use RentGorilla\Repositories\RentalRepository;

class UpdateSearchCounts implements ShouldBeQueued {

	use InteractsWithQueue;

    /**
     * @var RentalRepository
     */
    private $repository;

    public function __construct(RentalRepository $repository)
	{
        $this->repository = $repository;
    }

	/**
	 * Handle the event.
	 *
	 * @param  SearchWasInitiated  $event
	 * @return void
	 */
	public function handle(SearchWasInitiated $event)
	{
        $this->repository->updateSearchViews($event->rentalIds);
	}

}
