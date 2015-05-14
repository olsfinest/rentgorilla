<?php namespace RentGorilla\Handlers\Commands;

use RentGorilla\Commands\ToggleLikeCommand;

use Illuminate\Queue\InteractsWithQueue;
use RentGorilla\Repositories\LikeRepository;
use RentGorilla\Repositories\RentalRepository;

class ToggleLikeCommandHandler {
    /**
     * @var RentalRepository
     */
    private $rentalRepository;
    /**
     * @var LikeRepository
     */
    private $likeRepository;


    public function __construct(RentalRepository $rentalRepository, LikeRepository $likeRepository)
	{
        $this->rentalRepository = $rentalRepository;
        $this->likeRepository = $likeRepository;
    }

	/**
	 * Handle the command.
	 *
	 * @param  ToggleLikeCommand  $command
	 * @return void
	 */
	public function handle(ToggleLikeCommand $command)
	{
		$rental = $this->rentalRepository->findByUUID($command->rental_id);

        $like = $this->likeRepository->toggle($command->user_id, $rental->id, $command->photo_id);

        $photo_id = $command->photo_id;

        return compact('like', 'photo_id');
	}

}
