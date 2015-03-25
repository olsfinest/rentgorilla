<?php namespace RentGorilla\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use RentGorilla\Http\Requests;
use RentGorilla\Http\Controllers\Controller;

use Illuminate\Http\Request;
use RentGorilla\Http\Requests\LoginRequest;

class SessionController extends Controller {

    const MESSAGE = 'These credentials do not match our records.';
    /**
     * @var Guard
     */
    private $auth;

    function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'confirmed' => 1
        ];

        if ($this->auth->attempt($credentials, $request->has('remember')))
        {
            if($request->ajax()) {
                return response()->json(['success' => true]);
            } else {
                return redirect()->intended(route('rental.index'));
            }
        }

        //user is not confirmed
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'confirmed' => 0
        ];

        if ($this->auth->attempt($credentials, false, false)) {
            if ($request->ajax()) {
                $html = view('app.resend-confirmation-form')->with('email', $request->email)->render();
                return response()->json(['message' => 'unconfirmed', 'html' => $html], 401);
            } else {
                return redirect()->route('register.unconfirmed')->with('email', $request->email);
            }
        }

        //credentials did not match...

        if($request->ajax()) {
            return response()->json(['message' => self::MESSAGE, 'success' => false], 401);
        } else {
            return redirect(route('home'))
                ->withInput()
                ->withErrors([
                    'email' => self::MESSAGE
                ]);
        }
    }

    public function logout()
    {
        $this->auth->logout();

        return redirect('/');
    }

}
