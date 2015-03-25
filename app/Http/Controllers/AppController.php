<?php namespace RentGorilla\Http\Controllers;

use Auth;
use RentGorilla\Repositories\UserRepository;
use Session;
use Input;
use RentGorilla\Http\Requests;
use RentGorilla\Http\Controllers\Controller;

use Illuminate\Http\Request;
use RentGorilla\Repositories\RentalRepository;

class AppController extends Controller {

    protected $rentalRepository;

    function __construct(RentalRepository $rentalRepository)
    {
        $this->rentalRepository = $rentalRepository;
    }

    public function showHome()
    {
        return view('app');
    }

    /**
     * Show list view
     * @return \Illuminate\View\View
     */
    public function showList()
    {
		return view('app.list');
	}

    /**
     * Show map view
     *
     * @return \Illuminate\View\View
     */
    public function showMap()
    {
		return view('app.map');
	}


    /**
     * Retrieve rental list for AJAX
     *
     * @param UserRepository $userRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getRentalList(UserRepository $userRepository)
	{

        $search = Input::only('location', 'type', 'availability', 'beds', 'price');

        foreach ($search as $key => $value) {
            Session::put($key, $value);
        }

        extract($search);

        if(Input::has('location')) {
            $location = explode(',', Input::get('location'));
            $city = $location[0];
            $province = trim($location[1]);
        } else {
            $city = null;
            $province = null;
        }

        $rentals = $this->rentalRepository->search($city, $province, $type, $availability, $beds, $price);

		if(Auth::check()) {
			$favourites = $userRepository->getFavouriteRentalIdsForUser(Auth::user());
		} else {
			$favourites = [];
		}

		$html = view('app.rental-list-hits', compact('rentals', 'favourites'))->render();

		return response()->json(['rentals' => $html]);
	}

    /**
     * Clear the search parameters
     *
     * @return mixed
     */
    public function clearSearch()
    {
        Session::forget('location');
        Session::forget('type');
        Session::forget('availability');
        Session::forget('beds');
        Session::forget('price');

        return redirect()->back();
    }

    public function getMarkers()
    {
        $north = Input::get('N');
        $south = Input::get('S');
        $west = Input::get('W');
        $east = Input::get('E');

        $search = Input::only('location', 'type', 'availability', 'beds', 'price');

        foreach ($search as $key => $value) {
            Session::put($key, $value);
        }

        extract($search);

        $markers = $this->rentalRepository->geographicSearch($north, $south, $west, $east, $type, $availability, $beds, $price);

        return $markers;

    }

    public function getRentalListForMap()
    {
        $ids = explode(',', Input::get('ids'));

        $rentals = $this->rentalRepository->getRentalsByIds($ids);

        return view('app.rental-map-hits', compact('rentals'));
    }

    public function getLocations()
    {
        $location = Input::get('location');

        return $this->rentalRepository->locationSearch($location['term']);
    }


}
