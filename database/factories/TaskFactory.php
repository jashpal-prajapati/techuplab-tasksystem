<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
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
        $status = ['New', 'Incomplete', 'Complete'];
        $priority = ['High', 'Medium', 'Low'];
        return [
            'subject' => fake()->name(),
            'description' => fake()->text(),
            'start_date' => now(),
            'due_date' => now(), // password
            'status' => $status[array_rand($status, 1)],
            'priority' => $priority[array_rand($priority, 1)]
        ];
    }
}
