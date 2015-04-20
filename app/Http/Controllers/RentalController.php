<?php namespace RentGorilla\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Input;
use Auth;
use RentGorilla\Commands\CreateRentalCommand;
use RentGorilla\Commands\EditRentalCommand;
use RentGorilla\Commands\EmailManagerCommand;
use RentGorilla\Commands\ToggleRentalActivationCommand;
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
use RentGorilla\Repositories\UserRepository;
use Validator;
use RentGorilla\Photo;
use RentGorilla\Repositories\RentalRepository;
use Config;
class RentalController extends Controller {

    protected $rentalRepository;
    /**
     * @var PromotionManager
     */
    protected $promotionManager;

    function __construct(RentalRepository $rentalRepository, PromotionManager $promotionManager)
    {
        $this->middleware('auth', ['except' => ['show', 'showPhone', 'sendManagerMail']]);
        $this->rentalRepository = $rentalRepository;
        $this->promotionManager = $promotionManager;
    }


    public function showPromotions()
    {
        $promoted = $this->rentalRepository->getPromotedRentals(Auth::user());
        $unpromoted = $this->rentalRepository->getUnpromotedRentals(Auth::user());

        return view('rental.promotions', compact('promoted', 'unpromoted'));
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

            if(Auth::user()->charge(Config::get('promotion.price'), ['currency' => 'cad', 'description' => 'Promotion for ' . $rental->street_address])) {
               $promotedNow = $this->promotionManager->promoteRental($rental);
            } else {
                $messages = new MessageBag();
                $messages->add('Stripe Error', 'There was a problem charging your card.');
                return redirect()->back()->withErrors($messages);
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
        if(Auth::check()) {
            $favourites = $userRepository->getFavouriteRentalIdsForUser(Auth::user());
        } else {
            $favourites = [];
        }

        $rental = $this->rentalRepository->findByUUID($id);

        return view('rental.show', compact('rental', 'favourites'));
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

    public function showPhone(RentalPhoneRequest $request)
    {
        $rental = $this->rentalRepository->findByUUID($request->input('rental_id'));

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
}