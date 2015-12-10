<?php

namespace PageLab\ServerMail\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use PageLab\ServerMail\Http\Requests;
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
        $tasks = $this->tasks->forUser($request->user());

        return response()->json(['success'=> 1, 'data' => $tasks]);
    }

    /**
     * Create a new task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255'
        ]);

        if ($validator->fails()){
            return response()->json(['success' => 0, 'data' => null, 'message' => $validator->errors()]);
        }

        $tasks = $request->user()->tasks();

        $newTask = $tasks->create([
            'name' => $request->name
        ]);

        return  response()->json(['success' => 1, 'data' => $newTask, 'message' => 'Task created successfully.']);;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $response = null;
        $task = $this->tasks->find($id);

        if ($task) {
            $task->name = $request->get('name');
            $task->save();

            $response = response()->json(['success' => 1, 'data' => $task, 'message' => 'Task ' . $task->id . ' updated successfully.']);
        }

       return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggleDone(Request $request, $id)
    {
        $task = $this->tasks->find($id);
        $response = null;
        if ($task) {
            $task->done = $request->get('done');
            $task->save();

            $response = response()->json([
                'success' => 1,
                'data' => $task,
                'message' => 'Task ' . $task->id . ' updated successfully.',
                'request' => $request->get('done')
            ]);
        }

        return $response;
    }

    /**
     * Destroy the given task.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        //$this->authorize('destroy', $task);
        $task = $this->tasks->find($id);
        $response = null;
        if ($task) {
            $task->delete();

            $response = response()->json(['success' => 1, 'data' => $task, 'message' => 'Task ' . $task->id . ' deleted successfully.']);
        }

        return $response;
    }
}
