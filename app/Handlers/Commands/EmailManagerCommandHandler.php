<?php namespace RentGorilla\Handlers\Commands;

use RentGorilla\Commands\EmailManagerCommand;

use Illuminate\Queue\InteractsWithQueue;
use RentGorilla\Mailers\UserMailer;
use RentGorilla\Repositories\RentalRepository;

class EmailManagerCommandHandler {


    /**
     * @var UserMailer
     */
    private $userMailer;
    /**
     * @var RentalRepository
     */
    private $rentalRepository;

    public function __construct(UserMailer $userMailer, RentalRepository $rentalRepository)
	{
        $this->userMailer = $userMailer;
        $this->rentalRepository = $rentalRepository;
    }

	/**
	 * Handle the command.
	 *
	 * @param  EmailManagerCommand  $command
	 * @return void
	 */
	public function handle(EmailManagerCommand $command)
	{
        $rental = $this->rentalRepository->findByUUID($command->rental_id);

        $this->rentalRepository->incrementEmailClick($rental);

        $user = $this->rentalRepository->getUserByRental($rental);

        $this->userMailer->sendContactManager($user, $rental, $command->fname, $command->lname, $command->message, $command->email);
	}

}
