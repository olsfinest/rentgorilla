<?php namespace RentGorilla\Handlers\Commands;

use RentGorilla\Commands\SupportRequestCommand;

use Illuminate\Queue\InteractsWithQueue;
use RentGorilla\Mailers\AdminMailer;
use RentGorilla\Repositories\UserRepository;

class SupportRequestCommandHandler {


    /**
     * @var AdminMailer
     */
    protected $mailer;
    /**
     * @var UserRepository
     */
    protected $userRepository;

    public function __construct(AdminMailer $mailer, UserRepository $userRepository)
	{
		//
        $this->mailer = $mailer;
        $this->userRepository = $userRepository;
    }

	/**
	 * Handle the command.
	 *
	 * @param  SupportRequestCommand  $command
	 * @return void
	 */
	public function handle(SupportRequestCommand $command)
	{
        $user = $this->userRepository->find($command->user_id);

        return $this->mailer->sendContactForm($user, $command->question);
	}

}
