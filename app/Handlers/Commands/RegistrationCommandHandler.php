<?php namespace RentGorilla\Handlers\Commands;

use RentGorilla\Commands\RegistrationCommand;

use Illuminate\Queue\InteractsWithQueue;
use RentGorilla\Events\UserHasRegistered;
use RentGorilla\Repositories\UserRepository;
use RentGorilla\User;

class RegistrationCommandHandler {

    protected $repository;

    public function __construct(UserRepository $repository)
	{
        $this->repository = $repository;
    }

	public function handle(RegistrationCommand $command)
	{
		$user = new User();
        $user->first_name = $command->first_name;
        $user->last_name = $command->last_name;
        $user->email = $command->email;
        $user->password = bcrypt($command->password);
        $user->user_type = $command->user_type;
        $user->confirmed = 0;
        $user->confirmation = str_random(40);

        $this->repository->save($user);

        event(new UserHasRegistered($user));

        return $user;

	}

}
