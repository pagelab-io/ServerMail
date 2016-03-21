<?php

namespace PageLab\ServerMail\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use PageLab\ServerMail\User;

class UserRepository extends BaseRepository
{

    /**
     * Return the namespace for User Model
     *
     * @return mixed|string
     */
    public function model(){
        return 'PageLab\ServerMail\User';
    }

    /**
     * Load all users in database
     *
     * @param Request $request
     * @return Collection
     */
    public function loadUsers(Request $request)
    {
        // Retrieve paginate users
        $users = User::orderby('created_at', 'desc');

        if ($request->get('name')) {
            $users->where('name', 'like', '%' . $request->get('name') . '%');
        }

        return $users->paginate()->appends($request->all());

    }

    /**
     * Creates a new user
     *
     * @param Request $request
     * @return User
     */
    public function createUser(Request $request)
    {
        $user = User::create([
            'name'      => $request->get('name'),
            'email'     => $request->get('email'),
            'password'  => bcrypt($request->get('password'))
        ]);

        if(!($user && $user instanceof User)) return null;

        return $user;
    }

    public function updateUser(array $data, $id)
    {
        // retrieve the user by Id
        $user = $this->byId($id);

        if (!($user && $user instanceof User)) return null;

        // update record
        $this->update($data, $id);

        return $user;
    }

    public function deleteUser($id)
    {
        $user = $this->byId($id);

        if ($user) {
            $user->delete();
            return true;
        }

        return false;
    }

}