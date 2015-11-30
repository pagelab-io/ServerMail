<?php

namespace PageLab\ServerMail\Repositories;

use PageLab\ServerMail\User;
use PageLab\ServerMail\Task;

class TaskRepository
{

    /**
     * Get the task by id
     *
     * @param int $id
     * @return Task
     */
    public function find($id){

        return Task::findOrFail($id);
    }

    /**
     * Get all of the tasks for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
    public function forUser(User $user)
    {
        return Task::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
    }
}
