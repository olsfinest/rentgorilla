<?php namespace RentGorilla\Http\Controllers;

use Auth;
use RentGorilla\Events\SearchWasInitiated;
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
        return view('app.home');
    }


    public function showList($location = null)
    {

        if($location) {
            if( ! $this->rentalRepository->locationExists($location)) {
                return abort(404);
            }
        }

        return view('app.list', compact('location'));

	}


    public function showMap($location = null)
    {
        if($location) {
            if( ! $this->rentalRepository->locationExists($location)) {
                return abort(404);
            }
        }

        return view('app.map', compact('location'));
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

        $page = (int) Input::get('page', 1);

        $paginate = (boolean) Input::get('paginate');

        extract($search);

        if(Input::has('location')) {
            $city = getCity($location);
            $province = getProvince($location);
        } else {
            $city = null;
            $province = null;
        }

        $rentals = $this->rentalRepository->search($page, $paginate, $city, $province, $type, $availability, $beds, $price);

        if( $rentals['results']->count()) {
            event(new SearchWasInitiated( $rentals['results']->lists('id')));
        }

        if(Auth::check()) {
			$favourites = $userRepository->getFavouriteRentalIdsForUser(Auth::user());
		} else {
			$favourites = [];
		}

        if($paginate) {
            $html = view('app.rental-list-hits-paginated')->with('rentals', $rentals['results'])->with('favourites', $favourites)->render();
        } else {
            $html = view('app.rental-list-hits')->with('rentals', $rentals['results'])->with('favourites', $favourites)->with('total', $rentals['count'])->render();
        }

		return response()->json(['rentals' => $html,
                'count' => $rentals['count'],
                'page' => $rentals['page'],
                'totalPages' => $rentals['totalPages']
        ]);
	}

    /**
     * Clear the search parameters
     *
     * @return mixed
     */
    public function clearSearch()
    {
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
