<?php

namespace App\Http\Controllers;

use App\Http\Requests\API\CreateTaskAPIRequest;
use App\Http\Requests\API\UpdateTaskAPIRequest;
use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class TaskController
 * @package App\Http\Controllers\API
 */

class TaskAPIController extends AppBaseController
{
    /** @var  TaskRepository */
    private $taskRepository;

    public function __construct(TaskRepository $taskRepo)
    {
        $this->middleware('auth:api', ['except' => ['index']]);

        $this->taskRepository = $taskRepo;
    }

    /**
     * Display a listing of the Task.
     * GET|HEAD /tasks
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $tasks = $this->taskRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($tasks->toArray(), 'Tasks retrieved successfully');
    }

    public function my_tasks(){
        $tasks = Task::where([
            ['student_id', auth('api')->user()->id],
            ['status', 1]
        ])->orderBy('id', 'desc')->get();



        return $this->sendResponse($tasks->toArray(), 'Tasks retrieved successfully');

    }

    /**
     * Store a newly created Task in storage.
     * POST /tasks
     *
     * @param CreateTaskAPIRequest $request
     *
     * @return Response
     */
    public function gen_name($file){
        //creates unique file name
        $fileName = $file->getClientOriginalName();
        $fileName = pathinfo($fileName, PATHINFO_FILENAME);
        //just takes file extension
        $ext = $file->getClientOriginalExtension();
        //filename to store
        $fileToStore = md5(uniqid($fileName))  . '.' . $ext;

        return $fileToStore;
    }


    public function store(CreateTaskAPIRequest $request)
    {
        $input = $request->except(['file', 'filesize', 'student_id']);

        $file = $request->file('file');
        $input['student_id'] = auth('api')->user()->id;
        //required if files from input exists
        if ($file) {
            $input['filesize'] = $file->getSize();

            $fileToStore = $this->gen_name($file);

            $file->move('files', $fileToStore);
            $input['file'] = $fileToStore;
        }

        $task = $this->taskRepository->create($input);

        return $this->sendResponse($task->toArray(), 'Task saved successfully');
    }

    /**
     * Display the specified Task.
     * GET|HEAD /tasks/{id}
     *
     * @param int $id
     *
     * @return Response
     */

    public function download_route($id){
        $task = $this->taskRepository->find($id);

        $task->student;
        $task->solution;
        $task->num_of_downloads+=1;
        $task->save();
//        files/08fa8bcf83ba94fba14a7ef8f8282d25.jpg
        return $this->sendResponse('files/'.$task->file, 'Task file route retrieved successfully');

    }

    public function show($id)
    {
        /** @var Task $task */
        $task = $this->taskRepository->find($id);

        $task->student;
        $task->solution;

        if (empty($task)) {
            return $this->sendError('Task not found');
        }

        return $this->sendResponse($task->toArray(), 'Task retrieved successfully');
    }

    /**
     * Update the specified Task in storage.
     * PUT/PATCH /tasks/{id}
     *
     * @param int $id
     * @param UpdateTaskAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTaskAPIRequest $request)
    {
        $input = $request->all();

        /** @var Task $task */
        $task = $this->taskRepository->find($id);

        if (empty($task)) {
            return $this->sendError('Task not found');
        }

        $file = $request->file('file');
        $input['student_id'] = auth('api')->user()->id;
        //required if files from input exists
        if ($file) {
            $input['filesize'] = $file->getSize();

            $fileToStore = $this->gen_name($file);
            //end of file name generation
            $file->move('files', $fileToStore);
            $input['file'] = $fileToStore;
        }

        $task = $this->taskRepository->update($input, $id);

        return $this->sendResponse($task->toArray(), 'Task updated successfully');
    }

    /**
     * Remove the specified Task from storage.
     * DELETE /tasks/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Task $task */
        $task = $this->taskRepository->find($id);

        if (empty($task)) {
            return $this->sendError('Task not found');
        }

        $task->delete();

        if ($task->file) {
            File::delete('files/'.$task->file);
        }

        return $this->sendResponse($id, 'Task deleted successfully');
    }
}
