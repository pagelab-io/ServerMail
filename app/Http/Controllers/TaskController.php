<?php

namespace PageLab\ServerMail\Http\Controllers;

use PageLab\ServerMail\Task;
use PageLab\ServerMail\Http\Requests;
use Illuminate\Http\Request;
use PageLab\ServerMail\Http\Controllers\Controller;
use PageLab\ServerMail\Repositories\TaskRepository;

class TaskController extends Controller
{
    
    /**
     * The task repository instance.
     *
     * @var TaskRepository
     */
    protected $tasks;

    /**
     * Create a new controller instance.
     *
     * @param TaskRepository $tasks
     * @return void
     */
    public function __construct(TaskRepository $tasks)
    {
        $this->middleware('auth');

        $this->tasks = $tasks;
    }

    /**
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view('tasks.index', [
            'tasks' => $this->tasks->forUser($request->user()),
        ]);
    }

    /**
     * Create a new task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $tasks = $request->user()->tasks();

        $tasks->create([
            'name' => $request->name,
        ]);

        return redirect('/tasks');
    }

    /**
     * Show the task
     * @param Request $request
     * @param Task $task
     */
    public function showTask(Request $request, Task $task){
        return $task;
    }

    /**
     * Destroy the given task.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function destroy(Request $request, Task $task)
    {
        $this->authorize('destroy', $task);

        //$task->delete();

        return redirect('/tasks');
    }
}
