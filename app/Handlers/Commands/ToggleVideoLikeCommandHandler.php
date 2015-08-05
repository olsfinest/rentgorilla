<?php namespace RentGorilla\Handlers\Commands;

use RentGorilla\Commands\ToggleVideoLikeCommand;

use Illuminate\Queue\InteractsWithQueue;
use RentGorilla\Repositories\RentalRepository;
use RentGorilla\Repositories\VideoLikesRepository;

class ToggleVideoLikeCommandHandler {


    /**
     * @var RentalRepository
     */
    public $rentalRepository;
    /**
     * @var VideoLikesRepository
     */
    public $videoLikesRepository;

    public function __construct(RentalRepository $rentalRepository, VideoLikesRepository $videoLikesRepository)
	{
        $this->rentalRepository = $rentalRepository;
        $this->videoLikesRepository = $videoLikesRepository;
    }

	/**
	 * Handle the command.
	 *
	 * @param  ToggleVideoLikeCommand  $command
	 * @return void
	 */
	public function handle(ToggleVideoLikeCommand $command)
	{
		$rental = $this->rentalRepository->findByUUID($command->rental_id);

        $like = $this->videoLikesRepository->toggle($command->user_id, $rental->id);

        $likeCount = $rental->videoLikedBy()->count();

        return compact('like', 'likeCount');
	}

}
