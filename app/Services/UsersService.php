<?php

namespace App\Services;


use App\Repositories\UserRepository;

class UsersService
{
    /**
     * @var $userRepository
     */
    protected $userRepository;

    /**
     * UserService constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    /**
     * Get user by id.
     *
     * @param $id
     * @return String
     */
    public function getById($id)
    {
        return $this->userRepository->makeModel()->with(['tasks', 'roles', 'permissions'])->find($id);
    }

    public function getByRole($limit, $role)
    {
        return $this->userRepository->makeModel()->whereHas('roles', function ($query) use($role){
            $query->where('name', '=', $role);
        })
            ->paginate($limit);
    }


    /**
     * Create new user.
     *
     * @param $input
     * @return String
     */
    public function create($input)
    {
        return $this->userRepository->create($input);
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
        return $this->userRepository->update($input, $id);
    }
}
