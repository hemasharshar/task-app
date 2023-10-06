<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\BaseRepository;

class TaskRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'title',
        'description',
        'assigned_to_id',
        'assigned_by_id'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Task::class;
    }
}
