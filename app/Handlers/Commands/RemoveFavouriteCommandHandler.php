<?php namespace RentGorilla\Handlers\Commands;

use RentGorilla\Commands\RemoveFavouriteCommand;

use Auth;

use Illuminate\Queue\InteractsWithQueue;
use RentGorilla\Repositories\FavouritesRepository;
use RentGorilla\Repositories\RentalRepository;

class RemoveFavouriteCommandHandler {


    /**
     * @var FavouritesRepository
     */
    protected $favouritesRepository;
    /**
     * @var RentalRepository
     */
    protected $rentalRepository;

    public function __construct(FavouritesRepository $favouritesRepository, RentalRepository $rentalRepository)
	{

        $this->favouritesRepository = $favouritesRepository;
        $this->rentalRepository = $rentalRepository;
    }

	/**
	 * Handle the command.
	 *
	 * @param  RemoveFavouriteCommand  $command
	 * @return void
	 */
	public function handle(RemoveFavouriteCommand $command)
	{
        $rental = $this->rentalRepository->findByUUID($command->rental_id);

		$this->favouritesRepository->removeFavouriteForUser(Auth::user(), $rental->id);
	}

}
