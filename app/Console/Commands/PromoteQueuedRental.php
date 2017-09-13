<?php

namespace RentGorilla\Console\Commands;

use Log;
use RentGorilla\Rental;
use RentGorilla\Location;
use Illuminate\Console\Command;
use RentGorilla\Mailers\UserMailer;
use RentGorilla\Repositories\RentalRepository;

class PromoteQueuedRental extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rg:promote-queued {location : the slug of the location}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Promotes next rental in the queue for a location.';

    /**
     * @var RentalRepository
     */
    protected $rentalRepository;

    /**
     * @var UserMailer
     */
    protected $mailer;

    /**
     * Create a new command instance.
     *
     * @param RentalRepository $rentalRepository
     * @param UserMailer $mailer
     */
    public function __construct(RentalRepository $rentalRepository, UserMailer $mailer)
    {
        parent::__construct();

        $this->rentalRepository = $rentalRepository;
        $this->mailer = $mailer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $locationSlug = $this->argument('location');

        $location = Location::where('slug', $locationSlug)->first();

        if( ! $location) {
            $this->info('Sorry could not find a location by the slug ' . $locationSlug . '.');
            return;
        }

        $queued = Rental::where(['location_id' => $location->id, 'queued' => 1])->orderBy('queued_at')->first();

        if( ! $queued) {
            $this->info('There are no queued rentals to be promoted in ' . $location->city . '.');
            return;
        }

        if ($this->confirm('Do you wish to promote ' . $queued->getAddress() . '? [y|N]')) {
            $this->rentalRepository->promoteRental($queued);
            $this->mailer->sendPromotionStart($queued->user, $queued);
            Log::info('Queued promotion started', ['rental_id' => $queued->id]);
            $this->info('Promoted ' . $queued->getAddress() . '.');
        }

        return;
    }
}
