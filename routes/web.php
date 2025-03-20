<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProblemController;
use App\Http\Controllers\ContestController;
use App\Http\Controllers\ContestSubmissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard Routes
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
// Teacher-Specific Routes
Route::middleware(['auth', 'role:teacher'])->group(function () {
    Route::get('/teacher/dashboard', function () {
        return view('teacher.dashboard');
    });

    // Contest Management
    Route::get('/contests/create', [ContestController::class, 'create'])->name('contests.create');
    Route::post('/contests/store', [ContestController::class, 'store'])->name('contests.store');
});
// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Problems
    Route::get('/problems', [ProblemController::class, 'index'])->name('problems.index');
    Route::get('/problems/{id}', [ProblemController::class, 'show'])->name('problems.show');
    Route::post('/problems/{id}/submit', [ProblemController::class, 'submit'])->name('problems.submit');

    // Contests (For Everyone)
    Route::get('/contests', [ContestController::class, 'index'])->name('contests.index');
    Route::get('/contests/{contest}', [ContestController::class, 'show'])->name('contests.show');
    Route::get('/contests/{contest}/problems/{problem}', [ContestController::class, 'solve'])->name('contests.solve');
    Route::get('/contests/{contest}/leaderboard', [ContestController::class, 'leaderboard'])->name('contests.leaderboard');

    // Submitting Code for Contest Problems
    Route::post('/contests/{contest}/problems/{problem}/submit', [ContestSubmissionController::class, 'submit'])->name('contests.submit');
});

// Student-Specific Routes
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/dashboard', function () {
        return view('student.dashboard');
    });
});

require __DIR__.'/auth.php';
