@extends('layouts.app')

@section('title', 'Task Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4><i class="fas fa-eye"></i> Task #{{ $task->id }} Details</h4>
                <div class="btn-group" role="group">
                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this task?')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Title:</strong></div>
                    <div class="col-md-9">{{ $task->title }}</div>
                </div>

                @if($task->description)
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Description:</strong></div>
                    <div class="col-md-9">{{ $task->description }}</div>
                </div>
                @endif

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Status:</strong></div>
                    <div class="col-md-9">
                        @php
                            $statusClass = [
                                'pending' => 'warning',
                                'in_progress' => 'primary',
                                'completed' => 'success'
                            ][$task->status];
                        @endphp
                        <span class="badge bg-{{ $statusClass }} fs-6">
                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                        </span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Priority:</strong></div>
                    <div class="col-md-9">
                        @php
                            $priorityClass = [
                                'low' => 'secondary',
                                'medium' => 'warning',
                                'high' => 'danger'
                            ][$task->priority];
                        @endphp
                        <span class="badge bg-{{ $priorityClass }} fs-6">
                            {{ ucfirst($task->priority) }}
                        </span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Due Date:</strong></div>
                    <div class="col-md-9">
                        @if($task->due_date)
                            {{ $task->due_date->format('F j, Y \a\t g:i A') }}
                            @if($task->due_date->isPast() && $task->status !== 'completed')
                                <span class="badge bg-danger ms-2">Overdue</span>
                            @endif
                        @else
                            <span class="text-muted">No due date set</span>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Created:</strong></div>
                    <div class="col-md-9">{{ $task->created_at->format('F j, Y \a\t g:i A') }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Last Updated:</strong></div>
                    <div class="col-md-9">{{ $task->updated_at->format('F j, Y \a\t g:i A') }}</div>
                </div>

                <hr>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
                        <i class="fas fa-list"></i> Back to Tasks
                    </a>
                    @if($task->status !== 'completed')
                    <form action="{{ route('tasks.update', $task) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="title" value="{{ $task->title }}">
                        <input type="hidden" name="description" value="{{ $task->description }}">
                        <input type="hidden" name="status" value="completed">
                        <input type="hidden" name="priority" value="{{ $task->priority }}">
                        <input type="hidden" name="due_date" value="{{ $task->due_date }}">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Mark as Completed
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
