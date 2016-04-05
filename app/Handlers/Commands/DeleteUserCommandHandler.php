<?php namespace RentGorilla\Handlers\Commands;

use RentGorilla\Billing\Biller;
use Illuminate\Queue\InteractsWithQueue;
use RentGorilla\Events\UserHasBeenDeleted;
use RentGorilla\Commands\DeleteUserCommand;
use RentGorilla\Repositories\UserRepository;

class DeleteUserCommandHandler
{
    /**
     * @var Biller
     */
    protected $biller;
    /**
     * @var UserRepository
     */
    protected $userRepository;

    public function __construct(UserRepository $userRepository, Biller $biller)
    {
        $this->userRepository = $userRepository;
        $this->biller = $biller;
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

        //delete their stripe info
        if($user->readyForBilling()) {
            $this->biller->deleteAccount($user->getStripeId());
        }

        event(new UserHasBeenDeleted($user));

        $this->userRepository->delete($command->id);
    }
}
