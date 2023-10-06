<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Remove all the records
        User::truncate();
        $users = User::factory(10000)->make();
        $chunks = $users->chunk(1000);

        $chunks->each(function ($chunk) {
            User::insert($chunk->toArray());
        });
    }
}
