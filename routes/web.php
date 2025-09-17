<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return redirect()->route('tasks.index');
});

Route::resource('tasks', TaskController::class);

// API routes for monitoring
Route::prefix('api')->group(function () {
    Route::get('tasks/stats', [TaskController::class, 'stats']);
});
