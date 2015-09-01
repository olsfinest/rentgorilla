<?php namespace RentGorilla\Http\Controllers;

use RentGorilla\Commands\AdminNewUserCommand;
use RentGorilla\Commands\SendActivationCommand;
use RentGorilla\Http\Requests;
use RentGorilla\Http\Controllers\Controller;

use Illuminate\Http\Request;
use RentGorilla\Http\Requests\AdminNewUserRequest;
use Auth;
use RentGorilla\Http\Requests\LoginAsUserRequest;
use RentGorilla\Http\Requests\SendActivationRequest;
use RentGorilla\Repositories\PhotoRepository;
use RentGorilla\Repositories\UserRepository;
use Input;

class AdminController extends Controller {


    /**
     * @var UserRepository
     */
    protected $userRepository;

    function __construct(UserRepository $userRepository)
    {
        $this->middleware('admin');
        $this->userRepository = $userRepository;
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

        if($request->get('login')) {
            Auth::loginUsingId($user->id);
            return redirect()->route('rental.index')->with('flash:success', 'You are now logged in as the new user.');
        }

        return redirect()->back()->with('flash:success', 'New user created!');
    }

    public function searchUsers()
    {
        $email = Input::get('email');

        return $this->userRepository->emailSearch($email['term']);
    }

    public function loginAsUser(LoginAsUserRequest $request)
    {

        $user = $this->userRepository->find($request->user_id);

        Auth::loginUsingId($user->id);

        return redirect()->route('rental.index')->with('flash:success', 'You are now logged in as ' . $user->email);

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

        $this->userRepository->delete($id);

        return redirect()->route('admin.searchUsers')->with('flash:success', 'User deleted.');

    }
}
