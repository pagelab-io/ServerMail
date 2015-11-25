<?php

namespace PageLab\Repositories;

use PageLab\ServerMail\User;

class UserRepository
{

    /**
     * Get all users
     *
     * @return Collection
     */
    public function search(){
        return User::all();
    }
}