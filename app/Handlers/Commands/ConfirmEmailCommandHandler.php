<?php namespace RentGorilla\Handlers\Commands;

use RentGorilla\Commands\ConfirmEmailCommand;
use RentGorilla\Events\UserHasConfirmed;
use RentGorilla\Repositories\UserRepository;

class ConfirmEmailCommandHandler {

    protected $userRepository;

	public function __construct(UserRepository $userRepository)
	{
        $this->userRepository = $userRepository;
    }

	/**
	 * Handle the command.
	 *
	 * @param  ConfirmEmailCommand  $command
	 * @return void
	 */
	public function handle(ConfirmEmailCommand $command)
	{

        $user = $this->userRepository->getUserByAttribute('confirmation', $command->token);

        $user = $this->userRepository->confirm($user);

        event(new UserHasConfirmed($user));

        return $user;

  	}

}
