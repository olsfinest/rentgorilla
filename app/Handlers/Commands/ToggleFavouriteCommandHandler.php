<?php namespace RentGorilla\Handlers\Commands;

use RentGorilla\Commands\ToggleFavouriteCommand;

use Illuminate\Queue\InteractsWithQueue;
use RentGorilla\Repositories\FavouritesRepository;
use RentGorilla\Repositories\RentalRepository;

class ToggleFavouriteCommandHandler {
    /**
     * @var FavouritesRepository
     */
    private $repository;
    /**
     * @var RentalRepository
     */
    private $rentalRepository;



    public function __construct(FavouritesRepository $repository, RentalRepository $rentalRepository)
	{
        $this->repository = $repository;
        $this->rentalRepository = $rentalRepository;
    }

	public function handle(ToggleFavouriteCommand $command)
	{

        $rental = $this->rentalRepository->findByUUID($command->rental_id);

        $favourite = $this->repository->toggle($command->user_id, $rental->id);

        $favouriteCount = $rental->favouritedBy()->count();

        return compact( 'favourite', 'favouriteCount');
	}

}