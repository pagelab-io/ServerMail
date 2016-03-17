<?php namespace PageLab\ServerMail\Http\Controllers\Dashboard;

use PageLab\ServerMail\Exceptions\CantDeleteUserException;
use PageLab\ServerMail\Http\Requests\UserRequest;
use PageLab\ServerMail\Http\Controllers\Controller;
use PageLab\ServerMail\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * Constructor method
     */
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return $this
     */
    public function index(Request $request){

        // Retrieve paginate users
        $users = User::orderby('created_at', 'desc');

        if ($request->get('name')) {
            $users->where('name', 'like', '%' . $request->get('name') . '%');
        }

        $users = $users->paginate()->appends($request->all());

        return view('dashboard.users.index')->with('users', $users);
    }

    /**
     * Register User
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
    {
        $this->validate($request, ['name' => 'required']);

        User::create([
            'name'      => $request->get('name'),
            'email'     => $request->get('email'),
            'password'  => bcrypt($request->get('password'))
        ]);

        return redirect('dashboard/users')
            ->with('status', 'User registered successfully')
            ->with('level', 'success');
    }

    /**
     * Show User Profile
     *
     * @param User $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('dashboard.users.edit', compact('user'));
    }

    /**
     * Update User Profile
     *
     * @param User $user
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(User $user, Request $request)
    {
        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required|email',
        ]);

        $user->name     = $request->get('name');
        $user->email    = $request->get('email');

        if ($request->get('password') !== '') {
            $user->password = bcrypt($request->get('password'));
        }

        $user->save();

        return redirect('dashboard/users')
            ->with('status', 'Usuario actualizado correctamente')
            ->with('level', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        // Find Domain
        $user = User::findOrFail($id);
        $response = null;

        if ($user) {

            if ($user->id == 1) {
                 return response()->json(['success' => 0, 'message' => 'Can´t delete the user.']);
            }

            $user->delete();
            $response = response()->json(['success' => 1, 'message' => 'User deleted successfully.']);
        }

        return $response;
    }
}
