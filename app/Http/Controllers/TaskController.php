<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\TaskRepository;
use App\Services\TasksService;
use Illuminate\Http\Request;
use Flash;
use Yajra\DataTables\DataTables;

class TaskController extends AppBaseController
{
    /** @var TaskRepository $taskRepository*/
    private $taskRepository;

    /** @var TasksService $tasksService*/
    private $tasksService;

    public function __construct(TaskRepository $taskRepo, TasksService $tasksService)
    {
        $this->taskRepository = $taskRepo;
        $this->tasksService = $tasksService;
    }

    /**
     * Display a listing of the Task.
     * @param Request $request
     */
    public function index(Request $request)
    {
        try {
            $tasks = $this->tasksService->getAll(10);

            return view('tasks.index')
                ->with('tasks', $tasks);
        } catch (\Exception $e) {
            Flash::error('something_went_wrong');

            return redirect(route('tasks.index'));
        }
    }

    /**
     * Show the form for creating a new Task.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created Task in storage.
     * @param CreateTaskRequest $request
     */
    public function store(CreateTaskRequest $request)
    {
        try {
            $input = $request->all();

            $task = $this->tasksService->create($input);
            Flash::success('Task saved successfully.');

            return redirect(route('tasks.index'));
        } catch (\Exception $e) {
            Flash::error('something_went_wrong');

            return redirect(route('tasks.index'));
        }
    }

    /**
     * Display the specified Task.
     */
    public function show($id)
    {
        $task = $this->taskRepository->find($id);

        if (empty($task)) {
            Flash::error('Task not found');

            return redirect(route('tasks.index'));
        }

        return view('tasks.show')->with('task', $task);
    }

    /**
     * Show the form for editing the specified Task.
     */
    public function edit($id)
    {
        $task = $this->taskRepository->find($id);

        if (empty($task)) {
            Flash::error('Task not found');

            return redirect(route('tasks.index'));
        }

        return view('tasks.edit')->with('task', $task);
    }

    /**
     * Update the specified Task in storage.
     */
    public function update($id, UpdateTaskRequest $request)
    {
        $task = $this->taskRepository->find($id);

        if (empty($task)) {
            Flash::error('Task not found');

            return redirect(route('tasks.index'));
        }

        $task = $this->taskRepository->update($request->all(), $id);

        Flash::success('Task updated successfully.');

        return redirect(route('tasks.index'));
    }

    /**
     * Remove the specified Task from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $task = $this->taskRepository->find($id);

        if (empty($task)) {
            Flash::error('Task not found');

            return redirect(route('tasks.index'));
        }

        $this->taskRepository->delete($id);

        Flash::success('Task deleted successfully.');

        return redirect(route('tasks.index'));
    }

    /**
     * Get Tasks For Datatable
     * @return \Illuminate\Http\JsonResponse
     */
    function getData()
    {
        try {
            $tasks = $this->taskRepository->model()::with(['user', 'admin']);
            return Datatables::of($tasks)
                ->make(true);
        } catch (\Exception $e) {
            return $this->sendError('Something Went Wrong', 500);
        }
    }

    /**
     * Get Users | Admins List For Create Task
     * @param $role
     * @return \Illuminate\Http\JsonResponse
     */
    function getUsers($role)
    {
        try {
            return $this->tasksService->getByRole(20,$role);
        } catch (\Exception $e) {
            return $this->sendError('Something Went Wrong', 500);
        }
    }
}
