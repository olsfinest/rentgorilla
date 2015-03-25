<?php namespace RentGorilla\Handlers\Commands;

use RentGorilla\Commands\ModifyProfileCommand;
use Illuminate\Queue\InteractsWithQueue;
use RentGorilla\Profile;
use RentGorilla\Repositories\ProfileRepository;
use RentGorilla\Repositories\UserRepository;

class ModifyProfileCommandHandler
{
    /**
     * @var UserRepository
     */
    protected $userRepository;
    /**
     * @var ProfileRepository
     */
    protected $profileRepository;

    public function __construct(UserRepository $userRepository, ProfileRepository $profileRepository)
    {
        $this->userRepository = $userRepository;
        $this->profileRepository = $profileRepository;
    }

    /**
     * Handle the command.
     *
     * @param  ModifyProfileCommand  $command
     * @return void
     */
    public function handle(ModifyProfileCommand $command)
    {
        $user = $this->userRepository->find($command->user_id);

        $profile = $this->profileRepository->getProfileForUser($user);

        $profile->primary_phone = nullIfEmpty($command->primary_phone);
        $profile->alternate_phone = nullIfEmpty($command->alternate_phone);
        $profile->website = nullIfEmpty($command->website);
        $profile->bio = nullIfEmpty($command->bio);

        return $this->profileRepository->save($profile);
    }
}
