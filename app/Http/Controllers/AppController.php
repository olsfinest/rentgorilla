<?php namespace RentGorilla\Http\Controllers;

use Auth;
use RentGorilla\Events\SearchWasInitiated;
use RentGorilla\Repositories\LocationRepository;
use RentGorilla\Repositories\UserRepository;
use Session;
use Input;
use RentGorilla\Http\Requests;
use RentGorilla\Http\Controllers\Controller;

use Illuminate\Http\Request;
use RentGorilla\Repositories\RentalRepository;
use Log;

class AppController extends Controller {

    protected $rentalRepository;
    /**
     * @var LocationRepository
     */
    protected $locationRepository;

    function __construct(RentalRepository $rentalRepository, LocationRepository $locationRepository)
    {
        $this->rentalRepository = $rentalRepository;
        $this->locationRepository = $locationRepository;
    }

    public function showHome()
    {
        return view('app.home');
    }

    public function showTerms()
    {
        return view('app.terms');
    }

    public function getCity($city = null)
    {
        if($city) {
            if($locations = $this->locationRepository->searchSlugForCity($city)) {

                if(count($locations) === 0) {
                    return app()->abort(404);
                }

                if(count($locations) > 1) {

                    return view('app.disambiguation', compact('locations'));
                }

                return redirect()->route('list', ['slug' => $locations->first()->slug]);
            }
        }
    }


    public function showList($location = null)
    {

        if($location) {

            $check = $this->locationRepository->fetchBySlug($location);
        }

        return view('app.list', compact('location'));

	}


    public function showMap($location = null)
    {
        if($location) {
            $check = $this->locationRepository->fetchBySlug($location);
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

        if(Input::get('sort')) {
            Session::put('sort', Input::get('sort'));
        }

        $page = (int) Input::get('page', 1);

        $paginate = (boolean) Input::get('paginate');

        extract($search);

        $location = $this->locationRepository->fetchBySlug($location);

        $rentals = $this->rentalRepository->search($page, $paginate, $location->id, $type, $availability, $beds, $price, session('sort'));

        if( $rentals['results']->count()) {
            event(new SearchWasInitiated( $rentals['results']->lists('id')->all()));
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
        Session::forget('sort');

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

        return $this->locationRepository->locationSearch($location['term']);
    }


}
