<?php

namespace PageLab\ServerMail\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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

    /**
     * Create a new task for the User in Session
     *
     * @param Request $request
     * @return Task
     */
    public function createTask(Request $request)
    {

        // get all related tasks with the user
        $tasks = $request->user()->tasks();

        // create the new task
        $newTask = $tasks->create([ 'name' => $request->name]);

        // if $newTask isn't instance of Task
        if (!($newTask instanceof Task)) return null;

        return $newTask;
    }

    /**
     * Update a specific task by id
     *
     * @param array $data
     * @param int $id
     * @return Task
     */
    public function updateTask(array $data, $id)
    {
        // retrieve the task by Id
        $task = $this->byId($id);

        if (!($task && $task instanceof Task)) return null;

        // update record
        $this->update($data, $id);

        return $task;
    }

    /**
     * Delete the specific task if exist
     * @param $id
     * @return bool
     */
    public function deleteTask($id)
    {

        $task = $this->byId($id);

        if ($task) {
            $task->delete();
            return true;
        }

        return false;
    }

}
