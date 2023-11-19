<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasRoles, HasFactory, HasApiTokens;
    public $table = 'users';

    public $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password'
    ];

    protected $casts = [
        'name' => 'string',
        'email' => 'string'
    ];

    protected $hidden = ['password'];
    public static $request_array = [
        'search'
    ];

    public function scopeApplyFilters($query)
    {
        $request_array = self::$request_array;
        foreach ($request_array as $item) $$item = request()->has($item) ? request($item) : false;

        $query
            ->when($search, function ($query) use ($search) {
                $query->where('users.name', 'like', '%' . $search . '%');
            });
    }

    public static array $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8'
    ];

    public function tasks()
    {
        return $this->hasMany('App\Models\Task', 'assigned_to_id', 'id');
    }

}
