<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {

        $managers = User::where('type', 'manager')->get();
        $users = User::where('type', 'user')->get();


        foreach ($managers as $manager) {
            for ($i = 1; $i <= 10; $i++) {
                $mainTask = Task::create([
                    'title' => "Main Task {$i} (Manager {$manager->id})",
                    'description' => "Detailed description for main task {$i} created by {$manager->name}",
                    'status' => 'pending',
                    'due_date' => fake()->dateTimeBetween('now', '+3 months'),
                    'created_by' => $manager->id,
                    'assigned_to' => $users->random()->id,
                    'parent_id' => null,
                ]);


                for ($j = 1; $j <= 2; $j++) {
                    Task::create([
                        'title' => "Subtask {$j} for {$mainTask->title}",
                        'description' => "Details for subtask {$j} belonging to {$mainTask->title}",
                        'status' => fake()->randomElement(['pending', 'canceled', 'completed']),
                        'due_date' => fake()->dateTimeBetween('now', $mainTask->due_date),
                        'created_by' => $manager->id,
                        'assigned_to' => $users->random()->id,
                        'parent_id' => $mainTask->id,
                    ]);
                }
            }
        }
    }
}
