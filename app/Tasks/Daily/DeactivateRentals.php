<?php namespace RentGorilla\Tasks\Daily;

use DB;
use RentGorilla\Mailers\UserMailer;
use RentGorilla\Repositories\RentalRepository;
use RentGorilla\Repositories\UserRepository;

class DeactivateRentals {


    /**
     * @var UserMailer
     */
    protected $mailer;
    /**
     * @var UserRepository
     */
    protected $userRepository;
    /**
     * @var RentalRepository
     */
    protected $rentalRepository;

    function __construct(UserRepository $userRepository, RentalRepository $rentalRepository, UserMailer $mailer)
    {
        $this->mailer = $mailer;
        $this->userRepository = $userRepository;
        $this->rentalRepository = $rentalRepository;
    }

    public function checkIfAccountExpired()
    {
        //note: this query is MySQL only. DATEDIFF function not available in sqlite
        $expiredUserIds = DB::table('users')
            ->select('id')
            ->where('confirmed', 1)
            ->where(function ($query){
                $query->whereRaw('DATEDIFF(trial_ends_at, NOW()) <= 0');
                $query->orWhereRaw('DATEDIFF(subscription_ends_at, NOW()) <= 0');
            })->orWhere(function ($query){
                $query->whereRaw('DATEDIFF(DATE_ADD(created_at, INTERVAL 1 YEAR), NOW()) <= 0');
                $query->where('stripe_active', 0);
            })->groupBy('id')
            ->get();

        dd($expiredUserIds);

        if(count($expiredUserIds)) {

           foreach($expiredUserIds as $id) {

               $user = $this->userRepository->find($id);

               if($this->rentalRepository->getActiveRentalCountForUser($user) > 0) {
                   $this->mailer->sendRentalsDeactivated($user);
               }
           }

           DB::table('rentals')->whereIn('user_id', $expiredUserIds)->update('active', 0);
       }
    }
}