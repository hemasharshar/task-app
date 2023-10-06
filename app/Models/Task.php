<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public $table = 'tasks';

    public $fillable = [
        'title',
        'description',
        'assigned_to_id',
        'assigned_by_id'
    ];

    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'assigned_to_id' => 'integer',
        'assigned_by_id' => 'integer'
    ];

    public static array $rules = [
        'title' => 'required',
        'description' => 'required',
        'assigned_to_id' => 'required|exists:users,id',
        'assigned_by_id' => 'required|exists:users,id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'assigned_to_id', 'id');
    }

    public function admin()
    {
        return $this->belongsTo('App\Models\User', 'assigned_by_id', 'id');
    }

}
