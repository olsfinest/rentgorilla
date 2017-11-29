<?php

namespace RentGorilla\Console\Commands;

use Log;
use RentGorilla\Rental;
use Illuminate\Console\Command;
use RentGorilla\Mailers\UserMailer;
use RentGorilla\Services\Signature\Signature;

class AvailabilityDateReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rg:availability-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends a reminder email every 30 days regarding date of availability.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param Signature $signature
     * @param UserMailer $mailer
     */
    public function handle(Signature $signature, UserMailer $mailer)
    {
        Log::info('Running ' . $this->getName());

        //send email every 30 days
        $rentals = Rental::with('user')
                            ->where('active', true)
                            ->whereRaw('DATEDIFF(NOW(), available_at) > 0')
                            ->whereRaw('MOD(DATEDIFF(NOW(), available_at), 30) = 0')
                            ->get();

        foreach ($rentals as $rental) {
            $mailer->sendAvailabilityReminder(
                $rental->user,
                $rental->uuid,
                $rental->getAddress(),
                $signature->sign([$rental->uuid])
            );
        }
    }
}
