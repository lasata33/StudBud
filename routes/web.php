<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\StudySessionController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\SuggestionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('subjects', SubjectController::class);
    Route::resource('tasks', TaskController::class);

    Route::post('/sessions/store', [StudySessionController::class, 'store'])->name('sessions.store');
    Route::get('/progress', [StudySessionController::class, 'progress'])->name('progress');

    Route::get('/suggestions', [SuggestionController::class, 'index'])->name('suggestions');

    Route::get('/goals', [GoalController::class, 'index'])->name('goals.index');
    Route::post('/goals', [GoalController::class, 'store'])->name('goals.store');

    Route::get('/pomodoro', function () {
    $subjects = \App\Models\Subject::where('user_id', auth()->id())->get();
    return view('pomodoro', compact('subjects'));
})->name('pomodoro');
});

require __DIR__.'/auth.php';