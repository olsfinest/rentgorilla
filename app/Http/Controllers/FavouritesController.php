<?php namespace RentGorilla\Http\Controllers;

use Input;
use Auth;
use RentGorilla\Commands\ToggleFavouriteCommand;
use RentGorilla\Http\Requests;
use RentGorilla\Http\Controllers\Controller;

use Illuminate\Http\Request;
use RentGorilla\Http\Requests\FavouriteRequest;
use RentGorilla\Repositories\FavouritesRepository;
use RentGorilla\Repositories\RentalRepository;

class FavouritesController extends Controller {

    protected $favouritesRepository;

    public function __construct(FavouritesRepository $favouritesRepository)
    {
        $this->middleware('auth');
        $this->favouritesRepository = $favouritesRepository;
    }

    public function toggleFavourite(FavouriteRequest $request)
	{
        $favourite = $this->dispatch( new ToggleFavouriteCommand(Auth::user()->id, $request->rental_id));

		return response()->json(compact('favourite'));
	}

    public function showFavourites()
    {
        $favourites = $this->favouritesRepository->findFavouritesForUser(Auth::user());

        return view('rental.favourites', compact('favourites'));
    }

    public function removeFavourite($id)
    {

        $this->favouritesRepository->removeFavouriteForUser(Auth::user(), $id);

        return redirect()->back();
    }
}
