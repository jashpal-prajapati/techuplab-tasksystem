<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\TaskSeederr;
use Illuminate\Database\Eloquent\Factories\Factory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TaskSeederr::class
        ]);
        // \App\Models\User::factory(10)->create();

        \App\Models\NoteFile::factory(2)->create([
            'file_name' => fake()->name(),
            'file_path' => 'uploads/notes',
            'note_id' => 3,
        ]);
    }
}
