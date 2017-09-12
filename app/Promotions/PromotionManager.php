<?php namespace RentGorilla\Promotions;

use Config;
use Carbon\Carbon;
use RentGorilla\Mailers\UserMailer;
use RentGorilla\Promotion;
use RentGorilla\Rental;
use RentGorilla\Repositories\RentalRepository;
use RentGorilla\Repositories\UserRepository;
use Log;

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

       if($rentals->count()) {

           foreach ($rentals as $rental) {

               if ($queued = Rental::where(['location_id' => $rental->location->id, 'queued' => 1])->orderBy('queued_at')->first()) {

                   $user = $this->getUser($queued);

                   if($queued->isNotFreePromotion()) {

                       if ($user->charge(Config::get('promotion.price'), ['description' => 'Promotion for ' . $queued->street_address])) {
                           $this->rentalRepository->promoteRental($queued);
                           $this->mailer->sendPromotionStart($user, $queued);
                           Log::info('Queued promotion started', ['rental_id' => $queued->id]);
                       } else {
                           Log::info('Charge failed for queued rental', ['user_id' => $user->id]);
                           $this->rentalRepository->unqueueRental($queued);
                           $this->mailer->sendPromotionChargeFailed($user, $queued);
                           //TODO::send email to admin that the charge failed?
                       }
                   } else {
                       $this->rentalRepository->promoteRental($queued);
                       $this->mailer->sendPromotionStart($user, $queued);
                       Log::info('Queued promotion started', ['rental_id' => $queued->id]);
                   }
               }

               $this->rentalRepository->unpromoteRental($rental);
               $this->mailer->sendPromotionEnded($this->getUser($rental), $rental);
               Log::info('Promotion ended', ['rental_id' => $rental->id]);
           }
       } else {
           Log::info('No promotions ended today');
       }
    }

    public function promoteRental(Rental $rental)
    {

       if($this->wontBeQueued($rental)) {
           $this->rentalRepository->promoteRental($rental);
           $this->mailer->sendPromotionStart($this->getUser($rental), $rental);
           Log::info('Promotion started', ['rental_id' => $rental->id]);
           return true;
       } else {
           //NOTE: for busy cities, the next available date could change rapidly, even between the time they saw the date available and the time they click buy!
           // that is why we have to send them the actual next available date
           $date = $this->getNextAvailablePromotionDate($rental);
           $this->mailer->sendPromotionQueued($this->getUser($rental), $rental, $date['dateAvailable']);
           $this->rentalRepository->queueRental($rental);
           Log::info('Promotion queued', ['rental_id' => $rental->id]);
           return false;
       }
    }

    public function getNextAvailablePromotionDate(Rental $rental)
    {
        if($currentReservationListLength = $this->totalReservations($rental->location)) {

            $activePromotions = Rental::where(['promoted' => 1, 'location_id' => $rental->location->id])->orderBy('promotion_ends_at')->take(Config::get('promotion.max'))->get();

            $model = [];

            for($i = 0; $i <= $currentReservationListLength; $i++) {
                foreach($activePromotions as $activePromotion) {
                    $model[] = $activePromotion->promotion_ends_at->addDays($i * Config::get('promotion.days'));
                }
            }

            $dateAvailable = $model[$currentReservationListLength];

            return ['dateAvailable' => $dateAvailable, 'daysRemaining' => $dateAvailable->diffInDays()];

        } else {

            $earliestPromotion = Rental::where(['promoted' => 1, 'location_id' => $rental->location->id])->orderBy('promotion_ends_at')->first();

            $dateAvailable = $earliestPromotion->promotion_ends_at;

            return ['dateAvailable' => $dateAvailable, 'daysRemaining' => $dateAvailable->diffInDays()];
        }
    }

    private function totalReservations($location)
    {
        return Rental::where(['location_id' => $location->id, 'queued' => 1])->count();
    }

    public function wontBeQueued(Rental $rental)
    {
        return  Rental::where(['promoted' => 1, 'location_id' => $rental->location->id])->count() < Config::get('promotion.max');
    }
}