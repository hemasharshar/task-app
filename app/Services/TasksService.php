<?php

namespace App\Services;


use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class TasksService
{
    /**
     * @var $userRepository
     */
    protected $userRepository;

    /** @var TaskRepository $taskRepository*/
    private $taskRepository;

    /**
     * UserService constructor.
     *
     * @param UserRepository $userRepository
     * @param TaskRepository $taskRepo
     */
    public function __construct(UserRepository $userRepository, TaskRepository $taskRepo)
    {
        $this->userRepository = $userRepository;
        $this->taskRepository = $taskRepo;
    }


    /**
     * Get user by id.
     *
     * @param $id
     * @return String
     */
    public function getById($id)
    {
        return $this->taskRepository->model()::with(['user', 'admin'])->find($id);
    }

    public function getByRole($limit, $role)
    {
        $expire = Carbon::now()->addMinutes(60);
        return Cache::remember('users', $expire, function() use($limit, $role){
            return $this->userRepository->model()::applyFilters()->whereHas('roles', function ($query) use($role){
                $query->where('name', '=', $role);
            })->select('id', 'name as text')->paginate($limit);
        });
    }

    public function getAll($limit)
    {
        return $this->taskRepository->model()::paginate($limit);
    }

    /**
     * Create new user.
     *
     * @param $input
     * @return String
     */
    public function create($input)
    {
        return $this->taskRepository->create($input);
    }

    /**
     * Update user.
     *
     * @param $input
     * @param $id
     * @return String
     */
    public function update($input, $id)
    {
        return $this->taskRepository->update($input, $id);
    }

    public function getTopUsers()
    {
        return $this->userRepository->getTopUsersTasks();
    }

    public function getTotalTasks()
    {
        return $this->taskRepository->model()::count();
    }

    public function getTotalAssignUsers()
    {
        return $this->userRepository->model()::has('tasks')->count();
    }
}
