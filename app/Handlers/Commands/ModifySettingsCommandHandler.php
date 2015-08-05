<?php namespace RentGorilla\Handlers\Commands;

use RentGorilla\Commands\ModifySettingsCommand;

use Illuminate\Queue\InteractsWithQueue;
use RentGorilla\Repositories\UserRepository;

class ModifySettingsCommandHandler {


    /**
     * @var UserRepository
     */
    protected $userRepository;

    function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    /**
	 * Handle the command.
	 *
	 * @param  ModifySettingsCommand  $command
	 * @return void
	 */
	public function handle(ModifySettingsCommand $command)
	{
		$user = $this->userRepository->find($command->user_id);

        $user->monthly_emails = $command->monthly_emails ? 1 : 0;

        return $this->userRepository->save($user);
  	}

}
