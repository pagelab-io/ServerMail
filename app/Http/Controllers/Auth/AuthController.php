<?php

namespace PageLab\ServerMail\Http\Controllers\Auth;


use PageLab\ServerMail\User;
use Validator;
use Illuminate\Support\Facades\Auth;
use PageLab\ServerMail\Http\Requests\LoginRequest;
use PageLab\ServerMail\Http\Controllers\Controller;
//use Illuminate\Foundation\Auth\ThrottlesLogins;
//use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    //use AuthenticatesAndRegistersUsers;//, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Show Login Form
     *
     * @return \Illuminate\View\View
     */
    public function showLogin(){
        return view('auth.login');
    }

    /**
     * Do Login
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin(LoginRequest $request){

        if(Auth::attempt([
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ], $request->get('remember'))){

            return redirect()
                ->intended('/home')
                ->with('status', 'Logged in successfully')
                ->with('level', 'success');
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('status', 'Wrong email or password')
            ->with('level', 'danger');
    }

    /**
     * Logout
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLogout(){
        Auth::logout();

        return redirect('/')
            ->with('status', 'Logged out successfully')
            ->with('level', 'success');
    }
}
