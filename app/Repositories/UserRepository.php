<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'email',
        'email_verified_at',
        'password'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return User::class;
    }

    /**
     * Get user by id.
     *
     * @param $id
     * @return String
     */
    public function getById($id)
    {
        return $this->model()::find($id);
    }

    public function getTopUsersTasks()
    {
        return $this->model()::whereHas('roles', function ($query){
            $query->where('name', '=', 'user');
        })->select("*",
                \DB::raw('(SELECT count(*) FROM tasks WHERE tasks.assigned_to_id = users.id) as user_task_count'))
            ->orderBy('user_task_count', 'DESC')->having('user_task_count', '>', 0)->limit(10)->get();
    }
}
