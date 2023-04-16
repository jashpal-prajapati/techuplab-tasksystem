<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskSeederr extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::factory()
            ->count(5)
            ->hasNotes(3)
            ->create();
    }
}
