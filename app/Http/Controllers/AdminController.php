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
use RentGorilla\Repositories\UserRepository;
use Input;

class AdminController extends Controller {


    function __construct()
    {
        $this->middleware('admin');
    }

    public function showCreateNewUser()
    {
        return view('admin.create-new-user');
    }

    public function showSearchUsers(UserRepository $userRepository)
    {
        $sortBy = Input::get('sortBy');
        $direction = Input::get('direction');

        $users = $userRepository->getPaginated(compact('sortBy', 'direction'));

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

    public function searchUsers(UserRepository $userRepository)
    {
        $email = Input::get('email');

        return $userRepository->emailSearch($email['term']);
    }

    public function loginAsUser(LoginAsUserRequest $request, UserRepository $userRepository)
    {

        $user = $userRepository->find($request->user_id);

        Auth::loginUsingId($user->id);

        return redirect()->route('rental.index')->with('flash:success', 'You are now logged in as ' . $user->email);

    }

    public function sendActivation(SendActivationRequest $request)
    {
       $success = $this->dispatchFrom(SendActivationCommand::class, $request);

       return redirect()->back()->with('flash:success', 'Activation email sent');
    }
}
