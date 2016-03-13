<?php

namespace PageLab\ServerMail\Repositories;

use PageLab\ServerMail\User;
use PageLab\ServerMail\Task;

class TaskRepository extends BaseRepository
{

    /**
     * Return the namespace for Task Model
     *
     * @return mixed|string
     */
    public function model()
    {
        return 'PageLab\ServerMail\Task';
    }

    /**
     * Get all of the tasks for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
    public function tasksByUser(User $user)
    {
        return Task::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
    }
}
