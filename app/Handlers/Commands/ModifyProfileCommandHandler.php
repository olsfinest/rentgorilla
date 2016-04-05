<?php namespace RentGorilla\Handlers\Commands;

use Image;
use RentGorilla\Profile;
use Illuminate\Queue\InteractsWithQueue;
use RentGorilla\Repositories\UserRepository;
use RentGorilla\Commands\ModifyProfileCommand;
use RentGorilla\Repositories\ProfileRepository;

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

            $upload_success = $image->resize(Profile::PHOTO_LARGE_MAX_WIDTH, null, function ($constraint) {
                                        $constraint->aspectRatio();
                                        $constraint->upsize();
                                    })->save($destinationPath . 'large' . $filename)
                                    ->fit(Profile::PHOTO_SIDE, Profile::PHOTO_SIDE)
                                    ->save($destinationPath . 'small' . $filename);

            if ($upload_success) {

                // delete old profile pics, if any
                if ( ! is_null($profile->photo)) {
                    $profile->deletePhotos();
                }

                $profile->photo = $filename;
            }
        }

        return $this->profileRepository->save($profile);
    }
}
