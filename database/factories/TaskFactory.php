<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->title(),
            'description' => fake()->text(),
            'assigned_to_id' => User::query()->whereHas('roles', function ($query){
                $query->where('name', '=', 'user');
            })->inRandomOrder()->first()->id,
            'assigned_by_id' => User::query()->whereHas('roles', function ($query){
                $query->where('name', '=', 'admin');
            })->inRandomOrder()->first()->id
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [

        ]);
    }
}
