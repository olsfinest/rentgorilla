<?php namespace RentGorilla\Promotions;

use Auth;
use Config;
use Carbon\Carbon;
use RentGorilla\Mailers\UserMailer;
use RentGorilla\Rental;
use RentGorilla\Repositories\RentalRepository;
use RentGorilla\Promotion;

class PromotionManager {

    protected $rentalRepository;
    /**
     * @var UserMailer
     */
    protected $mailer;

    function __construct(RentalRepository $rentalRepository, UserMailer $mailer)
    {
        $this->rentalRepository = $rentalRepository;
        $this->mailer = $mailer;
    }

    public function processPromotionQueue(Rental $rental = null)
    {
        // you may pass a rental to this method to process the queue immediately (e.g. when a property is deleted)
        if($rental && $rental->isPromoted()) {
            $rentals = [$rental];
        } else {
            $rentals = Rental::where('promoted', 1)->where('promotion_ends_at', '<', Carbon::now())->get();
        }

        foreach($rentals as $rental) {

            if($promotion = Promotion::where(['city' => $rental->city, 'province' => $rental->province])->first()) {

                $rentalToBePromoted = $this->rentalRepository->find($promotion->rental_id);

                $this->rentalRepository->promoteRental($rentalToBePromoted);

                $this->mailer->sendPromotionStart(Auth::user(), $rentalToBePromoted);

                $promotion->delete();

            } else {

                $this->rentalRepository->unpromoteRental($rental);
            }

            $this->mailer->sendPromotionEnded(Auth::user(), $rental);

        }
    }

    public function promoteRental(Rental $rental)
    {

       if(Rental::where(['promoted' => 1, 'city' => $rental->city, 'province' => $rental->province])->get()->count() < Config::get('promotion.max')) {
           $this->rentalRepository->promoteRental($rental);
           $this->mailer->sendPromotionStart(Auth::user(), $rental);
           return true;
       } else {
           //NOTE: for busy cities, the next available date could change rapidly, even between the time they saw the date available and the time they click buy!
           // that is why we have to send them the actual next available date
           $date = $this->getNextAvailablePromotionDate($rental);
           $this->mailer->sendPromotionQueued(Auth::user(), $rental, $date);

           //rental->waitListed = 1
           //put rental on waiting list
           Promotion::create(['user_id' => Auth::id(), 'rental_id' => $rental->id, 'city' => $rental->city, 'province' => $rental->province]);
           return false;
       }

    }

    public function getNextAvailablePromotionDate(Rental $rental)
    {
        if($currentReservationListLength = $this->totalReservations($rental->city, $rental->province)) {

            $activePromotions = Rental::where(['promoted' => 1, 'city' => $rental->city, 'province' => $rental->province])->orderBy('promotion_ends_at')->take(Config::get('promotion.max'))->get();

            $model = [];

            for($i = 0; $i <= $currentReservationListLength; $i++) {
                foreach($activePromotions as $activePromotion) {
                    $model[] = $activePromotion->promotion_ends_at->addDays($i * Config::get('promotion.days'));
                }
            }

            $dateAvailable = $model[$currentReservationListLength];

            return ['dateAvailable' => $dateAvailable, 'daysRemaining' => $dateAvailable->diffInDays()];

        } else {

            $earliestPromotion = Rental::where(['promoted' => 1, 'city' => $rental->city, 'province' => $rental->province])->orderBy('promotion_ends_at')->first();

            if($earliestPromotion) {

                $dateAvailable = $earliestPromotion->promotion_ends_at;

                return ['dateAvailable' => $dateAvailable, 'daysRemaining' => $dateAvailable->diffInDays()];

            } else {

                return false;
            }

        }
    }

    private function totalReservations($city, $province)
    {
        return Promotion::where(['city' => $city, 'province' => $province])->get()->count();
    }


}