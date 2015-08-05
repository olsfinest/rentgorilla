<?php namespace RentGorilla\Handlers\Commands;

use RentGorilla\Commands\AdminNewUserCommand;

use Illuminate\Queue\InteractsWithQueue;
use RentGorilla\Repositories\UserRepository;
use RentGorilla\User;
use Log;

class AdminNewUserCommandHandler {


    /**
     * @var UserRepository
     */
    protected $repository;

    public function __construct(UserRepository $repository)
	{
	    $this->repository = $repository;
    }

	/**
	 * Handle the command.
	 *
	 * @param  AdminNewUserCommand  $command
	 * @return void
	 */
	public function handle(AdminNewUserCommand $command)
	{

        $user = new User();
        $user->first_name = nullIfEmpty($command->first_name);
        $user->last_name = nullIfEmpty($command->last_name);
        $user->email = $command->email;
        $user->password = bcrypt(str_random(10));
        $user->confirmed = 0;
        $user->confirmation = str_random(40);
        $user->is_admin = is_null($command->is_admin) ? 0 : 1;
        $user->provider = 'email';
        $this->repository->save($user);

        Log::info('New admin created', ['id' => $user->id]);

        return $user;
	}

}
