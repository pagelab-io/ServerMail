<?php

namespace PageLab\Repositories;

use PageLab\ServerMail\Repositories\BaseRepository;
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

}