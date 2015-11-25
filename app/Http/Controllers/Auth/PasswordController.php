<?php

namespace PageLab\ServerMail\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PageLab\ServerMail\Http\Controllers\Controller;
use PageLab\ServerMail\User;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    /**
     * Create a new password controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Post email method
     * @return \Illuminate\Http\Response
     */
    public function getEmail(){
        // Send email
        return view('auth.password');
    }

    /**
     * Get reset email reset form
     *
     * @param string $token
     * @return \Illuminate\Http\Response
     */
    public function getReset($token){
        // Send email
        return view('auth.reset')->with('token', $token);
    }

    /**
     * Send an e-email reminder to the user.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEmail(Request $request){
        // Send email
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        $user = User::email($request->get('email'))->firstOrFail();

        /* Send email link*/
        Mail::send('emails.reminder', ['user' => $user], function ($m) use ($user) {
            $m->from('soporte@pagelab.io', 'Email Server App');
            $m->to($user->email, $user->name)->subject('Your Password Reset Link');
        });

        return redirect('auth/password/recovery')
            ->with('status', 'A link was send to email for reset your password.')
            ->with('level', 'success');

    }

    /**
     *
     */
    public function postReset(){

    }
}
