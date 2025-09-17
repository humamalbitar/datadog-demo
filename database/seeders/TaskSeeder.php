<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a mix of different tasks for demo purposes
        
        // Create 15 regular tasks with random status/priority
        Task::factory()
            ->count(15)
            ->create();

        // Create 5 pending high-priority tasks
        Task::factory()
            ->count(5)
            ->pending()
            ->highPriority()
            ->create();

        // Create 3 completed tasks
        Task::factory()
            ->count(3)
            ->completed()
            ->create();

        // Create 4 in-progress tasks
        Task::factory()
            ->count(4)
            ->inProgress()
            ->create();

        // Create 2 overdue tasks (good for monitoring alerts)
        Task::factory()
            ->count(2)
            ->overdue()
            ->create();

        // Create 3 urgent tasks (high priority with near due dates)
        Task::factory()
            ->count(3)
            ->urgent()
            ->create();

        // Create some specific demo tasks with known titles
        Task::factory()->create([
            'title' => 'Set up Datadog monitoring dashboard',
            'description' => 'Configure custom metrics and alerts for application performance monitoring.',
            'status' => 'completed',
            'priority' => 'high',
            'due_date' => now()->subDays(1),
        ]);

        Task::factory()->create([
            'title' => 'Implement user authentication system',
            'description' => 'Add login, registration, and password reset functionality.',
            'status' => 'in_progress',
            'priority' => 'high',
            'due_date' => now()->addDays(5),
        ]);

        Task::factory()->create([
            'title' => 'Write API documentation',
            'description' => 'Document all API endpoints with examples and response formats.',
            'status' => 'pending',
            'priority' => 'medium',
            'due_date' => now()->addDays(10),
        ]);

        Task::factory()->create([
            'title' => 'Optimize database queries',
            'description' => 'Review and optimize slow database queries identified by monitoring tools.',
            'status' => 'pending',
            'priority' => 'medium',
            'due_date' => now()->addDays(7),
        ]);

        Task::factory()->create([
            'title' => 'Deploy to production environment',
            'description' => 'Configure production deployment pipeline and deploy the application.',
            'status' => 'pending',
            'priority' => 'high',
            'due_date' => now()->addDays(3),
        ]);
    }
}
