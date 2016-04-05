<?php

namespace RentGorilla\Handlers\Commands;

use Auth;
use RentGorilla\Commands\EditUserCommand;
use RentGorilla\Events\UserInfoChanged;
use RentGorilla\Repositories\UserRepository;

class EditUserCommandHandler
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * Create the command handler.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param EditUserCommand $command
     * @return mixed
     */
    public function handle(EditUserCommand $command)
    {
        $user = $this->userRepository->find($command->id);

        if($user->isSuper() && ! Auth::user()->isSuper()) {
            abort(401);
        }

        $user->first_name = nullIfEmpty($command->first_name);
        $user->last_name = nullIfEmpty($command->last_name);
        $oldEmail = $user->email;
        $user->email = $command->email;
        $user->save();

        event(new UserInfoChanged($oldEmail, $user));

        return $user;
    }
}
