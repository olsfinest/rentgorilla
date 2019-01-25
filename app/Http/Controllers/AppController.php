<?php namespace RentGorilla\Http\Controllers;

use RentGorilla\Area;
use RentGorilla\Repositories\LocationRepository;
use RentGorilla\Repositories\RentalRepository;
use RentGorilla\Http\Controllers\Controller;
use RentGorilla\Repositories\UserRepository;
use RentGorilla\Events\SearchWasInitiated;
use RentGorilla\Http\Requests;
use Illuminate\Http\Request;
use RentGorilla\Location;
use RentGorilla\Photo;
use Response;
use Session;
use Cookie;
use Input;
use Auth;
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
        $areas = Area::selectRaw('name as city, slug, province, 0 as rentalsCount')
            ->whereHas('locations.rentals', function ($query) {
                $query->where('active', 1);
            })->get()->toArray();

        $locations = Location::leftJoin('rentals', 'rentals.location_id', '=', 'locations.id')
            ->selectRaw('locations.city, locations.slug, locations.province, count(*) as rentalsCount')
            ->where('rentals.active', 1)
            ->orderBy('locations.city')
            ->groupBy('locations.id')
            ->get()->toArray();

        $locations = array_merge($areas, $locations);

        return view('app.home', compact('locations'));
    }

    public function getLocationsForArea($id)
    {
        return Location::leftJoin('areas', 'locations.area_id', '=', 'areas.id')
            ->leftJoin('rentals', 'rentals.location_id', '=', 'locations.id')
            ->selectRaw('locations.city, locations.slug, locations.province, count(*) as rentalsCount')
            ->where('areas.slug', $id)
            ->where('rentals.active', 1)
            ->orderBy('locations.city')
            ->groupBy('locations.id')
            ->get();
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

                session(['location_id' => $locations->first()->id]);

                return redirect()->route('list', ['slug' => $locations->first()->slug]);
            }
        }
    }


    public function showList(Request $request = null, $location = null)
    {
        $showLandingPage = true;

        if($location) {

            $loc = $this->locationRepository->fetchBySlug($location);

            if(is_null($loc)) return redirect()->route('home');

            $showLandingPage = ! $request->hasCookie($location);

            session(['location_id' => $loc->id]);

        } else {
            return redirect()->route('home');
        }

        return view('app.list', compact('location', 'loc', 'showLandingPage'));
	}


    public function setLandingPageCookie(Request $request){

        if($cookieName = $request->session()->get('location')) {
            // 4 days
            Cookie::queue($cookieName, false, 60 * 24 * 4);
        }
        //note we just need to return any response to set the cookie
        return Response::make('test');
    }

    public function deleteLandingPageCookie(Request $request){

        if($request->session()->get('location') && $request->hasCookie($request->session()->get('location')))
        {
            $cookie = Cookie::forget($request->session()->get('location'));
            Cookie::queue($cookie);
        }
        //note we just need to return any response to set the cookie
        return Response::make('test');
    }

    public function showMap(Request $request = null, $location = null)
    {
        $showLandingPage = true;

        if($location) {

            $loc = $this->locationRepository->fetchBySlug($location);

            if(is_null($loc)) return redirect()->route('home');

            $showLandingPage = ! $request->hasCookie($location);

            session(['location_id' => $loc->id]);

        } else {
            return redirect()->route('home');
        }

        return view('app.map', compact('location', 'loc', 'showLandingPage'));
    }


    /**
     * Retrieve rental list for AJAX
     *
     * @param UserRepository $userRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getRentalList(UserRepository $userRepository, Request $request)
	{

        $search = Input::only('type', 'availability', 'beds', 'price');

        foreach ($search as $key => $value) {
            session([$key => $value]);
        }

        if($request->has('sort')) {
            $sort = $request->get('sort');
            //bug fix, default edited_at should be in descending order
            if($sort == 'edited_at-ASC') {
                $sort = 'edited_at-DESC';
            }
            session(['sort' => $sort]);
        }

        $page = (int) Input::get('page', 1);
        session(['page' => $page]);

        $paginate = (boolean) Input::get('paginate');

        extract($search);

        $locationSlug = Input::get('location');

        $location = $this->locationRepository->fetchBySlug($locationSlug);

        if($location) {
            session(['location' => $locationSlug]);
            session(['location_id' => $location->id]);
        }

        $showLandingPage = ! $request->hasCookie($locationSlug);

        $rentals = $this->rentalRepository->search($page, $paginate, $location->id, $type, $availability, $beds, $price, session('sort'));

        if( $rentals['results']->count()) {
            event(new SearchWasInitiated( $rentals['results']->lists('id')->all(), $location->id));
        }

        if(Auth::check()) {
			$favourites = $userRepository->getFavouriteRentalIdsForUser(Auth::user());
		} else {
			$favourites = [];
		}

        $noPhotos = Photo::getNoPhotos('small');

        if($paginate) {
            $html = view('app.rental-list-hits-paginated')->with('noPhotos', $noPhotos)->with('loc', $location)->with('showLandingPage', $showLandingPage)->with('rentals', $rentals['results'])->with('favourites', $favourites)->render();
        } else {
            $html = view('app.rental-list-hits')->with('noPhotos', $noPhotos)->with('loc', $location)->with('showLandingPage', $showLandingPage)->with('rentals', $rentals['results'])->with('favourites', $favourites)->with('total', $rentals['count'])->render();
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

        return redirect()->route('list', session('location'));
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

        $noPhotos = Photo::getNoPhotos('small');

        return view('app.rental-map-hits', compact('noPhotos', 'rentals'));
    }

    public function getLocations()
    {
        $location = Input::get('location');

        return $this->locationRepository->locationSearch($location['term']);
    }


}
