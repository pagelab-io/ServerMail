<?php namespace PageLab\ServerMail\Http\Controllers\Dashboard;

use PageLab\ServerMail\Http\Requests\UserRequest;
use PageLab\ServerMail\Http\Controllers\Controller;
use PageLab\ServerMail\Repositories\UserRepository;
use PageLab\ServerMail\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * The user repository instance.
     *
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * Constructor method
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository){
        $this->middleware('auth');
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return $this
     */
    public function index(Request $request)
    {
        $users = $this->userRepository->loadUsers($request);
        return view('dashboard.users.index')->with('users', $users);
    }

    /**
     * Show User Registration Form
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('dashboard.users.create');
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

        $newUser = $this->userRepository->createUser($request);

        if ($newUser instanceof User) {
            return redirect("dashboard/users")
                ->with("status", "Usuario registrado correctamente")
                ->with("level", "success");
        } else {
            return redirect('dashboard/users')
                ->with('status', 'Ocurrio una incidencia al registrar al usuario, intentalo nuevamente')
                ->with('level', 'warning');
        }

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

        $data = ['name' => $request->get('name'), 'email' => $request->get('email')];

        if ($request->get('password') !== '')
            $data['password'] = bcrypt($request->get('password'));


        if ($this->userRepository->updateUser($data, $user->id)) {
            return redirect('dashboard/users')
                ->with('status', 'Usuario actualizado correctamente')
                ->with('level', 'success');
        } else {
            return redirect('dashboard/users')
                ->with('status', 'Ocurrio una incidencia al actualizar el registo, intentalo de nuevo')
                ->with('level', 'warning');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){

        if ($this->userRepository->deleteUser($id)) {
            return response()->json(['success' => 1, 'message' => 'Usuario eliminado correctamente.']);
        } else {
            return response()->json(['success' => 0, 'message' => 'No se puede eliminar al usuario']);
        }
    }
}
