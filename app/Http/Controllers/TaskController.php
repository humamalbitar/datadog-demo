<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DataDog\DogStatsd;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $startTime = microtime(true);
        
        // Log for Datadog monitoring
        Log::info('Tasks index page accessed', [
            'user_id' => auth()->id(),
            'timestamp' => now()
        ]);

        // Increment page view counter
        app(DogStatsd::class)->increment('tasks.index.views', 1, ['page' => 'index']);

        $tasks = Task::with([])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Send metrics to Datadog
        app(DogStatsd::class)->histogram('tasks.page.load_time', microtime(true) - $startTime);
        app(DogStatsd::class)->gauge('tasks.total.count', $tasks->total());

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Log::info('Task creation form accessed');
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date'
        ]);

        try {
            $task = Task::create($validated);
            
            Log::info('Task created successfully', [
                'task_id' => $task->id,
                'title' => $task->title,
                'priority' => $task->priority
            ]);

            // Send metrics to Datadog
            app(DogStatsd::class)->increment('tasks.created', 1, [
                'priority' => $task->priority,
                'status' => $task->status
            ]);

            return redirect()->route('tasks.index')
                ->with('success', 'Task created successfully!');
                
        } catch (\Exception $e) {
            Log::error('Failed to create task', [
                'error' => $e->getMessage(),
                'data' => $validated
            ]);

            // Track errors in Datadog
            app(DogStatsd::class)->increment('tasks.errors', 1, ['operation' => 'create']);

            return back()->with('error', 'Failed to create task.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        Log::info('Task viewed', ['task_id' => $task->id]);
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        Log::info('Task edit form accessed', ['task_id' => $task->id]);
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date'
        ]);

        try {
            $oldStatus = $task->status;
            $task->update($validated);
            
            Log::info('Task updated successfully', [
                'task_id' => $task->id,
                'old_status' => $oldStatus,
                'new_status' => $task->status
            ]);

            // Send metrics to Datadog for task updates
            app(DogStatsd::class)->increment('tasks.updated', 1, [
                'old_status' => $oldStatus,
                'new_status' => $task->status,
                'priority' => $task->priority
            ]);

            // Track task completion specifically
            if ($task->status === 'completed' && $oldStatus !== 'completed') {
                app(DogStatsd::class)->increment('tasks.completed', 1, [
                    'priority' => $task->priority,
                    'previous_status' => $oldStatus
                ]);
            }

            return redirect()->route('tasks.index')
                ->with('success', 'Task updated successfully!');
                
        } catch (\Exception $e) {
            Log::error('Failed to update task', [
                'task_id' => $task->id,
                'error' => $e->getMessage()
            ]);

            // Track errors in Datadog
            app(DogStatsd::class)->increment('tasks.errors', 1, ['operation' => 'update']);

            return back()->with('error', 'Failed to update task.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        try {
            $taskId = $task->id;
            $taskStatus = $task->status;
            $taskPriority = $task->priority;
            
            $task->delete();
            
            Log::info('Task deleted successfully', ['task_id' => $taskId]);

            // Send metrics to Datadog
            app(DogStatsd::class)->increment('tasks.deleted', 1, [
                'status' => $taskStatus,
                'priority' => $taskPriority
            ]);

            return redirect()->route('tasks.index')
                ->with('success', 'Task deleted successfully!');
                
        } catch (\Exception $e) {
            Log::error('Failed to delete task', [
                'task_id' => $task->id,
                'error' => $e->getMessage()
            ]);

            // Track errors in Datadog
            app(DogStatsd::class)->increment('tasks.errors', 1, ['operation' => 'delete']);

            return back()->with('error', 'Failed to delete task.');
        }
    }

    /**
     * API endpoint for dashboard stats - useful for Datadog monitoring
     */
    public function stats()
    {
        $stats = [
            'total_tasks' => Task::count(),
            'completed_tasks' => Task::completed()->count(),
            'pending_tasks' => Task::pending()->count(),
            'high_priority_tasks' => Task::highPriority()->count(),
        ];

        Log::info('Task stats requested', $stats);

        return response()->json($stats);
    }
}
