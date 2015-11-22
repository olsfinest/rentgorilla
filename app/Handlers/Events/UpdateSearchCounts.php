<?php namespace RentGorilla\Handlers\Events;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use RentGorilla\Events\SearchWasInitiated;

use Illuminate\Queue\InteractsWithQueue;
use RentGorilla\Jobs\Job;
use RentGorilla\MonthlySearches;
use RentGorilla\Repositories\RentalRepository;

class UpdateSearchCounts extends Job implements SelfHandling, ShouldQueue {

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

        if($event->locationId) {

            $ms = MonthlySearches::where([
                'location_id' => $event->locationId,
                'month' => date('m'),
                'year' => date('Y')])
                ->first();

            if($ms) {
                $ms->increment('searches');
            } else {
               MonthlySearches::create([
                   'location_id' => $event->locationId,
                   'month' => date('m'),
                   'year' => date('Y'),
                   'searches' => 1]);
            }
        }
	}

}
