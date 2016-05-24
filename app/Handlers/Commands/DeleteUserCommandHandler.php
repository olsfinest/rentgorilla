<?php namespace RentGorilla\Handlers\Commands;

use RentGorilla\Repositories\UserRepository;
use RentGorilla\Commands\DeleteUserCommand;
use RentGorilla\Events\UserHasBeenDeleted;
use Illuminate\Queue\InteractsWithQueue;

class DeleteUserCommandHandler
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Handle the command.
     *
     * @param  DeleteUserCommand  $command
     * @return void
     */
    public function handle(DeleteUserCommand $command)
    {
        $user = $this->userRepository->find($command->id);

        //can't delete super admins
        if($user->isSuper()) {
            return abort(404);
        }

        //delete their profile picture
        $user->deleteProfilePhotos();

        //delete their rental property photos
        foreach($user->photos as $photo) {
            $photo->deleteAllSizes();
        }

        event(new UserHasBeenDeleted($user));

        $this->userRepository->delete($command->id);
    }
}
