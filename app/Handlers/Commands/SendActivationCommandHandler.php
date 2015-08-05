<?php namespace RentGorilla\Handlers\Commands;

use RentGorilla\Commands\SendActivationCommand;

use Illuminate\Queue\InteractsWithQueue;
use RentGorilla\Mailers\UserMailer;
use RentGorilla\Repositories\UserRepository;
use Password;
use Illuminate\Contracts\Auth\PasswordBroker;

class SendActivationCommandHandler {


    /**
     * @var UserRepository
     */
    protected $userRepository;
    /**
     * @var UserMailer
     */
    protected $mailer;


    public function __construct(UserRepository $userRepository, UserMailer $mailer)
	{
        $this->userRepository = $userRepository;
        $this->mailer = $mailer;
    }

	/**
	 * Handle the command.
	 *
	 * @param  SendActivationCommand  $command
	 * @return void
	 */
	public function handle(SendActivationCommand $command)
	{
		$user = $this->userRepository->find($command->user_id);

        $token = app('auth.password.tokens')->create($user);

        return $this->mailer->sendPasswordResetToNewUser($user, $token);

 	}

}
