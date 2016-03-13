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

    /**
     * Create a new authentication controller instance.
     */
    public function __construct() {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Show Login Form
     *
     * @return \Illuminate\View\View
     */
    /*public function showLogin(){
        return view('auth.login');
    }*/

    /**
     * Este método es llamado por la ruta auth.login para llevar a cabo el proceso de loggin
     * - Primero se hace el intento de loggin y se valida que los campos sean correctos con Auth::attempt
     * - Si se valido correctamente se regresa true y si no false
     * - Dependiendo la respuesta se va a redireccionar al usuario al home o a la misma vista
     *   con sus respectivos mensajes de error.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin(LoginRequest $request) {

        $redirect = null;

        // loggin attempt
        $attempt = Auth::attempt([
            'email'     => $request->get('email'),
            'password'  => $request->get('password')
        ], $request->get('remember'));


        if ($attempt) {

            $redirect = redirect()
                ->intended('/home')
                ->with('status', 'Sesión iniciada correctamente')
                ->with('level', 'success');
        } else {

            $redirect =redirect()
                ->back()
                ->withInput()
                ->with('status', 'correo electrónico y/o contraseña equivocados')
                ->with('level', 'danger');
        }

        return $redirect;

    }

    /**
     * Logout
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLogout() {

        Auth::logout();

        return redirect('/')
            ->with('status', 'Sesión cerrada correctamente')
            ->with('level', 'success');
    }

}
