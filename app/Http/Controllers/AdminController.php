<?php namespace RentGorilla\Http\Controllers;

use Auth;
use Input;
use Subscription;
use RentGorilla\User;
use Illuminate\Http\Request;
use RentGorilla\Http\Requests;
use RentGorilla\Commands\EditUserCommand;
use RentGorilla\Commands\DeleteUserCommand;
use RentGorilla\Http\Controllers\Controller;
use RentGorilla\Repositories\UserRepository;
use RentGorilla\Commands\AdminNewUserCommand;
use RentGorilla\Http\Requests\EditUserRequest;
use RentGorilla\Repositories\RentalRepository;
use RentGorilla\Commands\SendActivationCommand;
use RentGorilla\Http\Requests\ModifyUserRequest;
use RentGorilla\Http\Requests\LoginAsUserRequest;
use RentGorilla\Http\Requests\AdminNewUserRequest;
use RentGorilla\Http\Requests\SendActivationRequest;

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
        $this->middleware('admin', ['except' => 'revert']);
        $this->middleware('auth', ['only' => 'revert']);
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
            session(['revert' => Auth::id()]);
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

    public function editUserByEmail(ModifyUserRequest $request)
    {
        $user = $this->userRepository->find($request->user_id);

        return redirect()->route('admin.user.edit', $user->id);
    }

    public function showDeleteUser($id)
    {
        $user = $this->userRepository->find($id);

        return view('admin.delete-user', compact('user'));
    }

    public function showEditUser($id)
    {
        $user = $this->userRepository->find($id);

        $rentals = $this->rentalRepository->getRentalsForUser($user);

        $active = $this->rentalRepository->getActiveRentalCountForUser($user);

        return view('admin.edit-user', compact('user', 'rentals', 'active'));
    }

    public function updateUser(EditUserRequest $request, $id)
    {
        $this->dispatchFrom(EditUserCommand::class, $request, ['id' => $id]);

        return redirect()->back()->with('flash:success', 'User updated.');
    }

    public function destroyUser($id)
    {
        $this->dispatch(new DeleteUserCommand($id));

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

        $plans = config('plans.plans');
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

    public function revert(Request $request)
    {
        if($request->session()->has('revert')) {
            Auth::loginUsingId($request->session()->get('revert'));
            $request->session()->forget('revert');
            return redirect()->route('admin.searchUsers')->with('flash:success', 'You are now logged in as ' . Auth::user()->email);
        }

        return redirect()->route('home');
    }
}
