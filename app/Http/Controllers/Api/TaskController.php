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
    protected $taskRepository;

    /**
     * Create a new controller instance.
     * @param TaskRepository $taskRepository
     */
    public function __construct(TaskRepository $taskRepository)
    {
        $this->middleware('auth');
        $this->taskRepository = $taskRepository;
    }

    /**
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {

        $response = null;
        $tasks = $this->taskRepository->tasksByUser($request->user());

        if ($tasks->isEmpty()) {
            $response = response()->json(['success'=> 0, 'data' => null]);
        } else {
            $response = response()->json(['success'=> 0, 'data' => $tasks]);
        }

        return $response;
    }

    /**
     * Create a new task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $response = [];
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255'
        ]);

        // validator fails
        if ($validator->fails()) {
            $response['success'] = -1;
            $response['data']    = null;
            $response['message'] = $validator->errors();
            return response()->json($response);
        }

        $newTask = $this->taskRepository->createTask($request);

        if ($newTask) {
            $response['success'] = 0;
            $response['data']    = $newTask;
            $response['message'] = "La tarea se creo correctamente";
        } else {
            $response['success'] = -1;
            $response['data']    = null;
            $response['message'] = "Ocurrio una incidencia al crear la tarea";
        }

        return response()->json($response);
    }

    /**
     * Update the name in the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateName(Request $request, $id)
    {
        $response = [];
        $data = ['name' => $request->get('name')];

        $task = $this->taskRepository->updateTask($data, $id);

        if ($task) {
            $response['success'] = 0;
            $response['data']    = $task;
            $response['message'] = "La tarea ".$id." ha sido actualizada correctamente.";
        } else {
            $response['success'] = -1;
            $response['data']    = null;
            $response['message'] = "Ocurrio una incidencia al actualizar la tarea";
        }

        return response()->json($response);
    }

    /**
     * Update the done attribute in the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggleDone(Request $request, $id)
    {
        $response = [];
        $data = ['done' => $request->get('done')];

        $task = $this->taskRepository->updateTask($data, $id);

        if ($task) {
            $response['success'] = 0;
            $response['data']    = $task;
            $response['message'] = "La tarea ".$id." ha sido actualizada correctamente.";
        } else {
            $response['success'] = -1;
            $response['data']    = null;
            $response['message'] = "Ocurrio una incidencia al actualizar la tarea";
        }

        return response()->json($response);
    }

    /**
     * Destroy the given task.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {

        $response = [];

        if ($this->taskRepository->deleteTask($id)) {
            $response['success'] = 0;
            $response['data']    = true;
            $response['message'] = "La tarea ".$id." ha sido eliminada correctamente.";
        } else {
            $response['success'] = -1;
            $response['data']    = false;
            $response['message'] = "La tarea ".$id." no se ha podido eliminar ya que no existe en la base de datos.";
        }

        return response()->json($response);
    }

}
