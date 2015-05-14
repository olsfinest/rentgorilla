<?php namespace RentGorilla\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;
use Input;
use Auth;
use RentGorilla\Commands\CreateRentalCommand;
use RentGorilla\Commands\EditRentalCommand;
use RentGorilla\Commands\EmailManagerCommand;
use RentGorilla\Commands\ToggleRentalActivationCommand;
use RentGorilla\Events\RentalViewed;
use RentGorilla\Handlers\Commands\ToggleRentalActivationCommandHandler;
use RentGorilla\Http\Requests;
use RentGorilla\Http\Controllers\Controller;
use RentGorilla\Http\Requests\EmailManagerRequest;
use RentGorilla\Http\Requests\ModifyRentalRequest;
use RentGorilla\Http\Requests\PromoteRentalExistingCustomerRequest;
use RentGorilla\Http\Requests\PromoteRentalNewCustomerRequest;
use RentGorilla\Http\Requests\RentalPhoneRequest;
use RentGorilla\Http\Requests\ToggleRentalActivationRequest;
use RentGorilla\Promotions\PromotionManager;
use RentGorilla\Repositories\PhotoRepository;
use RentGorilla\Repositories\UserRepository;
use Validator;
use RentGorilla\Photo;
use RentGorilla\Repositories\RentalRepository;
use Config;
use Image;

class RentalController extends Controller {


    protected $rentalRepository;
    /**
     * @var PromotionManager
     */
    protected $promotionManager;
    /**
     * @var PhotoRepository
     */
    protected $photoRepository;

    function __construct(RentalRepository $rentalRepository, PromotionManager $promotionManager, PhotoRepository $photoRepository)
    {
        $this->middleware('auth', ['except' => ['show', 'showPhone', 'sendManagerMail']]);
        $this->rentalRepository = $rentalRepository;
        $this->promotionManager = $promotionManager;
        $this->photoRepository = $photoRepository;
    }


    public function showPromotions()
    {
        $promoted = $this->rentalRepository->getPromotedRentals(Auth::user());
        $unpromoted = $this->rentalRepository->getUnpromotedRentals(Auth::user());

        $price = number_format(Config::get('promotion.price')/100, 2);

        return view('rental.promotions', compact('promoted', 'unpromoted', 'price'));
    }


    public function promoteRentalNewCustomer(PromoteRentalNewCustomerRequest $request)
    {
        $rental = $this->rentalRepository->findRentalForUser(Auth::user(), $request->rental_id);

        try {
           $customer = Auth::user()->subscription()->createStripeCustomer($request->stripe_token, [
                'email' => Auth::user()->email
            ]);

            Auth::user()->setStripeId($customer->id);
            Auth::user()->save();

            if($promotedNow = $this->promotionManager->wontBeQueued($rental)) {
                if (Auth::user()->charge(Config::get('promotion.price'), ['description' => 'Promotion for ' . $rental->street_address])) {
                    $this->promotionManager->promoteRental($rental);
                } else {
                    $messages = new MessageBag();
                    $messages->add('Stripe Error', 'There was a problem charging your card.');
                    return redirect()->back()->withErrors($messages);
                }
            }
        } catch (\Exception $e) {

            $messages = new MessageBag();
            $messages->add('Stripe Error', $e->getMessage());
            return redirect()->back()->withErrors($messages);

        }

        if($promotedNow) {
            $message = 'Your property has been promoted!';
        } else {
            $message = 'Your promotion has been queued!';
        }

        return redirect()->back()->with('flash_message', $message);
    }

    public function promoteRentalExistingCustomer(PromoteRentalExistingCustomerRequest $request)
    {

        $rental = $this->rentalRepository->findRentalForUser(Auth::user(), $request->rental_id);

        if(Auth::user()->charge(Config::get('promotion.price'), ['currency' => 'cad', 'description' => 'Promotion for ' . $rental->street_address])) {
            $promotedNow = $this->promotionManager->promoteRental($rental);
        } else {
            $messages = new MessageBag();
            $messages->add('Stripe Error', 'There was a problem charging your card.');
            return redirect()->back()->withErrors($messages);
        }

        if($promotedNow) {
            $message = 'Your property has been promoted!';
        } else {
            $message = 'Your promotion has been queued!';
        }

        return redirect()->back()->with('flash_message', $message);

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


	public function create()
	{
		return view('rental.create');
	}


	public function store(ModifyRentalRequest $request)
	{
        $rental = $this->dispatchFrom(CreateRentalCommand::class, $request, [
            'user_id' => Auth::id()
        ]);

        return redirect()->route('rental.photos.index', [$rental->uuid])->with('flash_message', 'Your property has been created! Now you may add photos!');
	}

	public function show($id, UserRepository $userRepository)
	{
        $rental = $this->rentalRepository->findByUUID($id);

        if(Auth::check()) {
            $favourites = $userRepository->getFavouriteRentalIdsForUser(Auth::user());
            $likes = $userRepository->getPhotoLikesForUser(Auth::user());
        } else {
            $favourites = [];
            $likes = [];
        }

        if(Session::has('location')) {
            $location = Session::get('location');
            $city = getCity($location);
            $province = getProvince($location);
        } else {
            $city = null;
            $province = null;
        }

        $search = $this->rentalRepository->uuids($city, $province, Session::get('type'), Session::get('availability'), Session::get('beds'), Session::get('price'));

        $index = array_search($id, $search);

        if($index !== false) {
            $previous = isset($search[$index - 1]) ? $search[$index - 1] : null;
            $next = isset($search[$index + 1]) ? $search[$index + 1] : null;
        } else {
            $previous = null;
            $next = null;
        }

        event(new RentalViewed($rental->id));

        return view('rental.show', compact('rental', 'favourites', 'likes', 'previous', 'next'));
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


	public function update($id, ModifyRentalRequest $request)
	{
        $rental = $this->rentalRepository->findRentalForUser(Auth::user(), $id);

        $rental = $this->dispatchFrom(EditRentalCommand::class, $request, [
            'id' => $rental->uuid
        ]);

        return redirect()->route('rental.index')->with('flash_message', 'Your property has been updated!');

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

        if($photos = $rental->photos) {
            foreach ($photos as $photo) {
                $photo->deleteAllSizes();
            }
        }

        $this->rentalRepository->delete($rental);

        return redirect()->back();
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

        $image = Image::make($file->getRealPath());

        $destinationPath = public_path() . '/img/uploads/';
        $randomString = str_random(12);
        $extension = $file->guessClientExtension();
        $filename = $randomString . ".{$extension}";

        $upload_success = $image->resize(1000, null, function ($constraint) {
                                    $constraint->aspectRatio();})
                                ->save($destinationPath . 'large' . $filename)
                                ->resize(625, null, function ($constraint) {
                                    $constraint->aspectRatio();})
                                ->save($destinationPath . 'medium' . $filename)
                                ->resize(237, null, function ($constraint) {
                                    $constraint->aspectRatio();})
                                ->save($destinationPath . 'small' . $filename);

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

    public function showPhone(RentalPhoneRequest $request)
    {
        $rental = $this->rentalRepository->findByUUID($request->input('rental_id'));

        $this->rentalRepository->incrementPhoneClick($rental);

        $phoneNumber = $this->rentalRepository->getPhoneByRental($rental);

        if ($phoneNumber) {
            return response()->json(['phone' => $phoneNumber]);
        } else {
            return response()->json(['phone' => 'No phone number provided']);
        }
    }

    public function sendManagerMail(EmailManagerRequest $request)
    {
        $this->dispatchFrom(EmailManagerCommand::class, $request);

        return response()->json(['message' => 'Mail sent!']);

    }

    public function deletePhoto($id) {

        $photo = $this->photoRepository->findPhotoForUser(Auth::user(), $id);

        $photo->deleteAllSizes();

        $this->photoRepository->delete($photo);

        return redirect()->back();
    }

}