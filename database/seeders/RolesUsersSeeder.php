<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name' => 'admin' , 'guard_name' => 'web', 'created_at' => Carbon::now()],
            ['name' => 'user' , 'guard_name' => 'web', 'created_at' => Carbon::now()]
        ];
        Role::insert($roles);
    }
}
