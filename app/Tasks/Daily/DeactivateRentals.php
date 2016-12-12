<?php namespace RentGorilla\Tasks\Daily;

use RentGorilla\Repositories\UserRepository;
use RentGorilla\Rental\RentalService;
use DB;

class DeactivateRentals {

    /**
     * @var UserRepository
     */
    protected $userRepository;
    /**
     * @var RentalService
     */
    protected $rentalService;

    /**
     * DeactivateRentals constructor.
     * @param UserRepository $userRepository
     * @param RentalService $rentalService
     */
    function __construct(UserRepository $userRepository, RentalService $rentalService)
    {
        $this->userRepository = $userRepository;
        $this->rentalService = $rentalService;
    }

    /**
     * Deactivates a user's rentals when ...
     * 1) Its the day after their trial ends
     * 2) If they are grandfathered and a year and a day passes
     * 3) If they are not grandfathered and three months and a day passes
     */
    public function checkIfAccountExpired()
    {
        $days = config('plans.freeForXDays');

        //note: this query is MySQL only. DATEDIFF function not available in sqlite
        $expiredUserIds = DB::table('users')
            ->select('id')
            ->where('confirmed', 1)
            ->where('stripe_active', 0)
            ->where(function ($query) use ($days) {
                $query->where(function ($query) {
                    $query->whereNotNull('trial_ends_at');
                    $query->whereRaw('DATEDIFF(`trial_ends_at`, NOW()) = -1');
                })->orWhere(function ($query) {
                    $query->where('is_grandfathered', 1);
                    $query->whereRaw('DATEDIFF(DATE_ADD(`created_at`, INTERVAL 1 YEAR), NOW()) = -1');
                })->orWhere(function ($query) use ($days)  {
                    $query->where('is_grandfathered', 0);
                    $query->whereRaw('DATEDIFF(DATE_ADD(`created_at`, INTERVAL ' . $days . ' DAY), NOW()) = -1');
                });
            })->groupBy('id')
            ->lists('id');

        if(count($expiredUserIds)) {
           foreach($expiredUserIds as $id) {
               $user = $this->userRepository->find($id);
               $this->rentalService->deactivateRentalsNow($user);
           }
       }
    }
}