<?php namespace RentGorilla\Promotions;

use Config;
use Carbon\Carbon;
use RentGorilla\Mailers\UserMailer;
use RentGorilla\Promotion;
use RentGorilla\Rental;
use RentGorilla\Repositories\RentalRepository;
use RentGorilla\Repositories\UserRepository;

class PromotionManager {
    /**
     * @var RentalRepository
     */
    protected $rentalRepository;
    /**
     * @var UserMailer
     */
    protected $mailer;
    /**
     * @var UserRepository
     */
    protected $userRepository;

    function __construct(RentalRepository $rentalRepository, UserMailer $mailer, UserRepository $userRepository)
    {
        $this->rentalRepository = $rentalRepository;
        $this->mailer = $mailer;
        $this->userRepository = $userRepository;
    }

    private function getUser(Rental $rental)
    {
        return $this->userRepository->find($rental->user_id);
    }

    public function processPromotionQueue()
    {

        $rentals = Rental::where('promoted', 1)->where('promotion_ends_at', '<', Carbon::now())->get();

        foreach($rentals as $rental) {

            if($queued = Rental::where(['location' => $rental->location, 'queued' => 1])->orderBy('queued_at')->first()) {

                $user = $this->getUser($queued);

                if($user->charge(Config::get('promotion.price'), ['description' => 'Promotion for ' . $queued->street_address])) {
                    $this->rentalRepository->promoteRental($queued);
                    $this->mailer->sendPromotionStart($user, $queued);
                    Promotion::create(['user_id' => $queued->user_id]);
                } else {
                    $this->rentalRepository->unqueueRental($queued);
                    $this->mailer->sendPromotionChargeFailed($user, $queued);
                    //TODO::send email to admin that the charge failed?
                }
            }

            $this->rentalRepository->unpromoteRental($rental);
            $this->mailer->sendPromotionEnded($this->getUser($rental), $rental);
        }
    }

    public function promoteRental(Rental $rental)
    {

       if($this->wontBeQueued($rental)) {
           $this->rentalRepository->promoteRental($rental);
           $this->mailer->sendPromotionStart($this->getUser($rental), $rental);
           Promotion::create(['user_id' => $rental->user_id]);
           return true;
       } else {
           //NOTE: for busy cities, the next available date could change rapidly, even between the time they saw the date available and the time they click buy!
           // that is why we have to send them the actual next available date
           $date = $this->getNextAvailablePromotionDate($rental);
           $this->mailer->sendPromotionQueued($this->getUser($rental), $rental, $date);
           $this->rentalRepository->queueRental($rental);
           return false;
       }
    }

    public function getNextAvailablePromotionDate(Rental $rental)
    {
        if($currentReservationListLength = $this->totalReservations($rental->location)) {

            $activePromotions = Rental::where(['promoted' => 1, 'location' => $rental->location])->orderBy('promotion_ends_at')->take(Config::get('promotion.max'))->get();

            $model = [];

            for($i = 0; $i <= $currentReservationListLength; $i++) {
                foreach($activePromotions as $activePromotion) {
                    $model[] = $activePromotion->promotion_ends_at->addDays($i * Config::get('promotion.days'));
                }
            }

            $dateAvailable = $model[$currentReservationListLength];

            return ['dateAvailable' => $dateAvailable, 'daysRemaining' => $dateAvailable->diffInDays()];

        } else {

            $earliestPromotion = Rental::where(['promoted' => 1, 'location' => $rental->location])->orderBy('promotion_ends_at')->first();

            if($earliestPromotion) {

                $dateAvailable = $earliestPromotion->promotion_ends_at;

                return ['dateAvailable' => $dateAvailable, 'daysRemaining' => $dateAvailable->diffInDays()];

            } else {

                return false;
            }

        }
    }

    private function totalReservations($location)
    {
        return Rental::where(['location' => $location, 'queued' => 1])->count();
    }

    public function wontBeQueued(Rental $rental)
    {
        return  Rental::where(['promoted' => 1, 'location' => $rental->location])->count() < Config::get('promotion.max');
    }
}