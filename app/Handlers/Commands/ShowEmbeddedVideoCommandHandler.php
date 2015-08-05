<?php namespace RentGorilla\Handlers\Commands;

use RentGorilla\Commands\ShowEmbeddedVideoCommand;

use Illuminate\Queue\InteractsWithQueue;
use RentGorilla\Repositories\RentalRepository;

use Embed;

class ShowEmbeddedVideoCommandHandler
{


    /**
     * @var RentalRepository
     */
    protected $rentalRepository;

    public function __construct(RentalRepository $rentalRepository)
    {
        $this->rentalRepository = $rentalRepository;
    }

    /**
     * Handle the command.
     *
     * @param  ShowEmbeddedVideoCommand $command
     * @return void
     */
    public function handle(ShowEmbeddedVideoCommand $command)
    {
        $rental = $this->rentalRepository->findByUUID($command->rental_id);

        if (is_null($rental->video)) {
            return ['player' => null, 'link' => null, 'id' => $rental->id];

        }

        $likes = $rental->videoLikedBy()->count();

        $embed = Embed::make($rental->video)->parseUrl();

        if ($embed) {

            $embed->setAttribute(['width' => 400]);

            return ['player' => $embed->getHtml(), 'link' => $rental->video, 'id' => $rental->id, 'likes' => $likes];

        } else {
            return ['player' => null, 'link' => $rental->video, 'id' => $rental->id, 'likes' => $likes];
        }
    }
}