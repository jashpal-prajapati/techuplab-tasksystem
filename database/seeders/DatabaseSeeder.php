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
        
        \App\Models\User::factory()->create([
            'name' => 'Jashpal Prajapati',
            'email' => 'j@gmail.com',
            'email_verified_at' => '2023-04-16 07:30:35',
            'password' => '$2y$10$nW/pOxi4Vx3IPJrzqj953e1noA.d8UmIicY/.99MEOReSqOhOOVyi', // password
            'remember_token' => '',
        ]);

        \App\Models\NoteFile::factory(2)->create([
            'file_name' => fake()->name(),
            'file_path' => 'uploads/notes',
            'note_id' => 3,
        ]);
    }
}
