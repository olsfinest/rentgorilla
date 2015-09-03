<?php namespace RentGorilla\Rewards;

use Carbon\Carbon;
use RentGorilla\Mailers\UserMailer;
use RentGorilla\Repositories\RentalRepository;
use RentGorilla\Repositories\UserRepository;
use RentGorilla\Reward;
use Config;
use Log;
use DB;
use RentGorilla\User;

abstract class Achievement {

    const GREAT_PHOTOS = 'GreatPhotos';
    const COMPLETE_PROFILE = 'CompleteProfile';
    const LOTS_OF_PHOTOS = 'LotsOfPhotos';
    const POWER_PROMOTER = 'PowerPromoter';
    const RENT_GORILLA = 'RentGorilla';
    const LOTS_OF_FAVOURITES = 'LotsOfFavourites';
    const CURRENT_LISTINGS = 'CurrentListings';
    const MOVIE_STAR = 'MovieStar';


    abstract public function getClassName();

    abstract public function checkEligibility();

    /**
     * @var UserRepository
     */
    protected $userRepository;
    /**
     * @var UserMailer
     */
    protected $userMailer;
    /**
     * @var RentalRepository
     */
    protected $rentalRepository;

    function __construct(UserRepository $userRepository, RentalRepository $rentalRepository, UserMailer $userMailer)
    {
        $this->userRepository = $userRepository;
        $this->userMailer = $userMailer;
        $this->rentalRepository = $rentalRepository;
    }

    public function checkAlreadyRewarded($users)
    {
        if($this->isMonthly()) {

            $alreadyRewardedUsers = DB::table('rewards')
                ->select('user_id')
                ->where('type', '=', $this->getClassName())
                ->whereNotNull('awarded_at')
                ->where('awarded_at', '>', Carbon::now()->subMonth())
                ->lists('user_id');

        } else {

            $alreadyRewardedUsers = DB::table('rewards')
                ->select('user_id')
                ->where('type', '=', $this->getClassName())
                ->lists('user_id');
        }

        $usersToBeRewarded = array_diff($users, $alreadyRewardedUsers);

        foreach($usersToBeRewarded as $user) {

            $user = $this->userRepository->find($user);

            //user must have at least one active rental
            if($this->rentalRepository->getActiveRentalCountForUser($user) > 0) {
                $this->reward($user);
            }
        }
    }

    public function reward(User $user)
    {
        Log::info('Achievement awarded: ' . $this->getClassName(), ['user_id' => $user->id]);

        $reward = Reward::updateOrCreate(['user_id' => $user->id, 'type' => $this->getClassName()], ['awarded_at' => Carbon::now()]);
        $reward->increment('award_count');

        $this->userRepository->awardPoints($user, $this->getPoints());

        $this->userMailer->sendAchievementAwarded($user, $this->getName(), $this->getPoints());

    }

    public function getDescription()
    {
        return Config::get('rewards.' . $this->getClassName() . '.description');
    }

    public function isMonthly()
    {
        return Config::get('rewards.' . $this->getClassName() . '.monthly');
    }

    public function getName()
    {
        return Config::get('rewards.' . $this->getClassName() . '.name');
    }

    public function getPoints()
    {
        return Config::get('rewards.' . $this->getClassName() . '.points');
    }
}