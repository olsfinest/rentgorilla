<?php namespace RentGorilla\Http\Controllers;

use RentGorilla\Commands\AdminNewUserCommand;
use RentGorilla\Commands\SendActivationCommand;
use RentGorilla\Events\UserHasBeenDeleted;
use RentGorilla\Http\Requests;
use RentGorilla\Http\Controllers\Controller;

use Illuminate\Http\Request;
use RentGorilla\Http\Requests\AdminNewUserRequest;
use Auth;
use RentGorilla\Http\Requests\LoginAsUserRequest;
use RentGorilla\Http\Requests\SendActivationRequest;
use Subscription;
use RentGorilla\Repositories\PhotoRepository;
use RentGorilla\Repositories\RentalRepository;
use RentGorilla\Repositories\UserRepository;
use Input;
use RentGorilla\User;

class AdminController extends Controller {


    /**
     * @var UserRepository
     */
    protected $userRepository;
    /**
     * @var RentalRepository
     */
    protected $rentalRepository;

    function __construct(UserRepository $userRepository, RentalRepository $rentalRepository)
    {
        $this->middleware('admin');
        $this->userRepository = $userRepository;
        $this->rentalRepository = $rentalRepository;
    }

    public function showCreateNewUser()
    {
        return view('admin.create-new-user');
    }

    public function showSearchUsers()
    {
        $sortBy = Input::get('sortBy');
        $direction = Input::get('direction');

        $users = $this->userRepository->getPaginated(compact('sortBy', 'direction'));

        return view('admin.search-users', compact('users'));
    }

    public function showSendActivation()
    {
        return view('admin.send-activation-email');
    }

    public function newUser(AdminNewUserRequest $request)
    {

        $user = $this->dispatchFrom(AdminNewUserCommand::class, $request);

        $is_admin = $user->is_admin ? ' admin' : '';

        if($request->get('login')) {
            Auth::loginUsingId($user->id);
            return redirect()->route('rental.index')->with('flash:success', "You are now logged in as the new{$is_admin} user.");
        }

        return redirect()->back()->with('flash:success', "New{$is_admin} user created!");
    }

    public function searchUsers()
    {
        $email = Input::get('email');

        return $this->userRepository->emailSearch($email['term']);
    }

    public function searchAddress()
    {
        $address = Input::get('address');

        return $this->rentalRepository->addressSearch($address['term']);
    }

    public function loginAsUser(LoginAsUserRequest $request)
    {

        $user = $this->userRepository->find($request->user_id);

        // One may only take over someones account if they are a super admin,
        // or if the user is not a super admin and the user has not used their credit card

        if(Auth::user()->isSuper() || ( ! $user->isSuper() &&  ! $user->readyForBilling() )) {

            Auth::loginUsingId($user->id);

            return redirect()->route('rental.index')->with('flash:success', 'You are now logged in as ' . $user->email);

        }

        return redirect()->back()->with('flash:success', 'Cannot log in as ' . $user->email . '. Permission denied.');
    }

    public function sendActivation(SendActivationRequest $request)
    {
       $success = $this->dispatchFrom(SendActivationCommand::class, $request);

       return redirect()->back()->with('flash:success', 'Activation email sent');
    }

    public function showDeleteUser($id)
    {
        $user = $this->userRepository->find($id);

        return view('admin.delete-user', compact('user'));
    }

    public function destroyUser($id, PhotoRepository $photoRepository)
    {

        $user = $this->userRepository->find($id);

        foreach($user->photos as $photo) {
            $photo->deleteAllSizes();
        }

        event(new UserHasBeenDeleted($user));

        $this->userRepository->delete($id);

        return redirect()->route('admin.searchUsers')->with('flash:success', 'User deleted.');

    }

    public function revenue()
    {
        $query = User::selectRaw('stripe_plan as plan, count(*) as count')
            ->where('stripe_active', 1)
            ->groupBy('stripe_plan')
            ->get()
            ->keyBy('plan')
            ->toArray();

        $revenue = [];
        $revenue['monthly_recurring'] = 0;
        $revenue['yearly_recurring'] = 0;

        $plans = config('plans');
        //remove free plan
        unset($plans['Free']);

        foreach($plans as $planId => $properties) {
            $plan = Subscription::plan($planId);
            $revenue['plans'][$planId]['count'] = isset($query[$planId]) ? $query[$planId]['count'] : 0;
            if($plan->isMonthly()) {
                $revenue['plans'][$planId]['price'] = $plan->monthlyBilledPrice() / 100;
                $revenue['plans'][$planId]['recurring'] = ($revenue['plans'][$planId]['count'] * $revenue['plans'][$planId]['price']);
                $revenue['monthly_recurring'] += $revenue['plans'][$planId]['recurring'];
            } else {
                $revenue['plans'][$planId]['price'] = $plan->totalYearlyCost() / 100;
                $revenue['plans'][$planId]['recurring'] = ($revenue['plans'][$planId]['count'] * $revenue['plans'][$planId]['price']);
                $revenue['yearly_recurring'] += $revenue['plans'][$planId]['recurring'];
            }
        }

        $revenue['total_yearly_recurring'] = ($revenue['monthly_recurring'] * 12) + $revenue['yearly_recurring'];

        return view('admin.revenue', compact('revenue'));
    }
}
