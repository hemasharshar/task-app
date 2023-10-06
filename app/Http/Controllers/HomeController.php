<?php

namespace App\Http\Controllers;

use App\Services\TasksService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /** @var TasksService $tasksService*/
    private $tasksService;

    /**
     * Create a new controller instance.
     * @param TasksService $tasksService
     * @return void
     */
    public function __construct(TasksService $tasksService)
    {
        $this->middleware('auth');
        $this->tasksService = $tasksService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $top_users_tasks = $this->tasksService->getTopUsers();
        $total_tasks = $this->tasksService->getTotalTasks();
        $total_assign_users = $this->tasksService->getTotalAssignUsers();
        return view('home')->with(['top_users_tasks' => $top_users_tasks, 'total_tasks' => $total_tasks, 'total_assign_users' => $total_assign_users]);
    }
}
