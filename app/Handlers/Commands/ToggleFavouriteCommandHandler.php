<?php namespace RentGorilla\Handlers\Commands;

use RentGorilla\Commands\ToggleFavouriteCommand;

use Illuminate\Queue\InteractsWithQueue;
use RentGorilla\Repositories\FavouritesRepository;

class ToggleFavouriteCommandHandler {
    /**
     * @var FavouritesRepository
     */
    private $repository;


    /**
     * @param FavouritesRepository $repository
     */
    public function __construct(FavouritesRepository $repository)
	{
        $this->repository = $repository;
    }

	/**
	 * Handle the command.
	 *
	 * @param  ToggleFavouriteCommand  $command
	 * @return void
	 */
	public function handle(ToggleFavouriteCommand $command)
	{
		return $this->repository->toggle($command->user_id, $command->rental_id);
	}

}