<?php

namespace RentGorilla\Http\Controllers;

use Illuminate\Http\Request;
use RentGorilla\Http\Requests;
use RentGorilla\Http\Controllers\Controller;
use RentGorilla\Promotions\PromotionManager;
use RentGorilla\Repositories\LocationRepository;
use RentGorilla\Repositories\RentalRepository;
use Input;

class AdminPromotionsController extends Controller
{

    /**
     * @var LocationRepository
     */
    protected $locationRepository;
    /**
     * @var RentalRepository
     */
    protected $rentalRepository;
    /**
     * @var PromotionManager
     */
    protected $promotionManager;

    public function __construct(LocationRepository $locationRepository, RentalRepository $rentalRepository, PromotionManager $promotionManager)
    {
        $this->middleware('super');
        $this->promotionManager = $promotionManager;
        $this->locationRepository = $locationRepository;
        $this->rentalRepository = $rentalRepository;
    }

    public function index($locationSlug = null)
    {
        $location = null;

        $locations = $this->locationRepository->getAll();

        if($locationSlug)
        {
            $location = $this->locationRepository->fetchBySlug($locationSlug);

            if( ! $location) app()->abort(404);

            return view('admin.promotions.index', compact('locationSlug', 'location', 'locations'));

        }

        return view('admin.promotions.index', compact('locationSlug', 'location', 'locations'));
    }

    public function changeLocation(Request $request)
    {
        return redirect()->route('admin.free-promotions.index', $request->location);
    }

    public function store(Request $request)
    {
        $rental = $this->rentalRepository->findByUUID($request->rental_id);

        $this->rentalRepository->freePromotion($rental);

        $wontBeQueued = $this->promotionManager->promoteRental($rental);

        if($wontBeQueued) {

            return redirect()->route('admin.free-promotions.index', $rental->location->slug)->with('flash:success', 'Free promotion has begun');

        } else {

            return redirect()->route('admin.free-promotions.index', $rental->location->slug)->with('flash:success', 'Free promotion has been queued');
        }
    }

    public function searchAddress($locationSlug)
    {
        $address = Input::get('address');

        $location = $this->locationRepository->fetchBySlug($locationSlug);

        return $this->rentalRepository->freePromotionAddressSearch($address['term'], $location->id);
    }

    public function cancel(Request $request)
    {
        $rental = $this->rentalRepository->findByUUID($request->rental_id);

        if ($rental->isNotFreePromotion())
        {
            return redirect()->route('admin.free-promotions.index', $rental->location->slug)->with('flash:success', 'The promotion cannot be canceled.');

        } else {

            $this->rentalRepository->unpromoteRental($rental);

            return redirect()->route('admin.free-promotions.index', $rental->location->slug)->with('flash:success', 'The promotion has been canceled.');
        }
    }

    public function confirmCancel($rental_id)
    {
        $rental = $this->rentalRepository->findByUUID($rental_id);

        return view('admin.promotions.confirm-cancel', compact('rental'));
    }

}
