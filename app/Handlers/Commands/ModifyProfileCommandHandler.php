<?php namespace RentGorilla\Handlers\Commands;

use RentGorilla\Commands\ModifyProfileCommand;
use Illuminate\Queue\InteractsWithQueue;
use RentGorilla\Profile;
use RentGorilla\Repositories\ProfileRepository;
use RentGorilla\Repositories\UserRepository;
use Image;

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
        $user->first_name = $command->first_name;
        $user->last_name = $command->last_name;
        $this->userRepository->save($user);

        $profile = $this->profileRepository->getProfileForUser($user);

        $profile->primary_phone = nullIfEmpty($command->primary_phone);
        $profile->website = nullIfEmpty($command->website);
        $profile->bio = nullIfEmpty($command->bio);
        $profile->company = nullIfEmpty($command->company);

        if(is_null($command->accepts_texts)) {
            $profile->accepts_texts = 0;
        } else {
            $profile->accepts_texts = (int) $command->accepts_texts;
        }

        if($command->photo) {

            $image = Image::make($command->photo->getRealPath());

            $destinationPath = public_path() . Profile::PHOTO_PATH;
            $randomString = str_random(12);
            $extension = $command->photo->guessClientExtension();
            $filename = $randomString . ".{$extension}";

            $upload_success = $image->fit(Profile::PHOTO_SIDE, Profile::PHOTO_SIDE)
                ->save($destinationPath . $filename);

            if ($upload_success) {

                // delete old profile pic, if any
                if ( ! is_null($profile->photo)) {
                    $profile->deletePhoto();
                }

                $profile->photo = $filename;
            }
        }


        return $this->profileRepository->save($profile);
    }
}
