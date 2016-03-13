<?php namespace PageLab\ServerMail\Http\Controllers;


use PageLab\ServerMail\Task;

class WelcomeController extends Controller {

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function index()
    {
        return view('welcome');
    }

}
