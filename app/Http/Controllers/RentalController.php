<?php namespace RentGorilla\Http\Controllers;

use Input;
use Auth;
use RentGorilla\Commands\ToggleRentalActivationCommand;
use RentGorilla\Handlers\Commands\ToggleRentalActivationCommandHandler;
use RentGorilla\Http\Requests;
use RentGorilla\Http\Controllers\Controller;
use RentGorilla\Http\Requests\ToggleRentalActivationRequest;
use Validator;
use Illuminate\Http\Request;
use RentGorilla\Photo;
use RentGorilla\Repositories\RentalRepository;

class RentalController extends Controller {

    protected $rentalRepository;

    function __construct(RentalRepository $rentalRepository)
    {
        $this->middleware('auth');
        $this->rentalRepository = $rentalRepository;
    }


    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$rentals = $this->rentalRepository->getRentalsForUser(Auth::user());

        return view('rental.index', compact('rentals'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('rental.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $rental = $this->rentalRepository->findRentalForUser(Auth::user(), $id);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$rental = $this->rentalRepository->findRentalForUser(Auth::user(), $id);

        return view('rental.edit', compact('rental'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $rental = $this->rentalRepository->findRentalForUser(Auth::user(), $id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $rental = $this->rentalRepository->findRentalForUser(Auth::user(), $id);
	}


    public function showPhotos($id)
    {
        $rental = $this->rentalRepository->findRentalForUser(Auth::user(), $id);

        return view('rental.photos', compact('rental'));
    }

    public function addPhoto($id, Request $request)
    {
        $rental = $this->rentalRepository->findRentalForUser(Auth::user(), $id);

        $v = Validator::make($request->all(), [
            'file' => 'mimes:jpeg,bmp,png,gif|max:3000',
        ]);

        if ($v->fails())
        {
            if ($request->ajax()) {
                return response()->json(['error' => $v->errors()->first()], 400);
            } else {
                return redirect()->back()->withErrors($v->errors());
            }
        }

        $file = Input::file('file');
        $destinationPath = public_path() . '/img/uploads';
        $randomString = str_random(12);
        $extension = $file->guessClientExtension();
        $filename = $randomString . ".{$extension}";

        $upload_success = $file->move($destinationPath, $filename);

        if( $upload_success ) {

            $photo = new Photo();
            $photo->name = $filename;
            $photo->rental_id = $rental->id;
            $photo->user_id = Auth::user()->id;
            $photo->save();

            if ($request->ajax()) {
                return response()->json('success', 200);
            } else {
                return redirect()->back();
            }

        } else {
            if ($request->ajax()) {
                return response()->json(['error' => 'There was a problem uploading the photo.'], 400);
            } else {
                return redirect()->back()->withErrors(['file' => 'There was a problem uploading the photo.']);
            }

        }
    }

    public function toggleActivate(ToggleRentalActivationRequest $request)
    {
        $rental = $this->rentalRepository->findRentalForUser(Auth::user(), $request->rental_id);

        $activated = $this->dispatch(new ToggleRentalActivationCommand($request->rental_id));

        if ($activated === ToggleRentalActivationCommandHandler::SUBSCRIPTION_NEEDED) {
            return response()->json(['message' => ToggleRentalActivationCommandHandler::SUBSCRIPTION_NEEDED], 401);
        } else {
            return response()->json(compact('activated'));
        }
   }
}