<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProblemController;
use App\Http\Controllers\ContestController;
use App\Http\Controllers\ContestSubmissionController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;

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


    Route::get('/teacher/contests', [TeacherController::class, 'manageContests'])->name('teacher.contests');
    Route::get('/teacher/problems', [TeacherController::class, 'manageProblems'])->name('teacher.problems');

    Route::get('/teacher/contests/create', [TeacherController::class, 'createContest'])->name('teacher.contests.create');
    Route::post('/teacher/contests/store', [TeacherController::class, 'storeContest'])->name('teacher.contests.store');
    Route::get('/teacher/contests/{contest}/edit', [TeacherController::class, 'editContest'])->name('teacher.contests.edit');
    Route::post('/teacher/contests/{contest}/update', [TeacherController::class, 'updateContest'])->name('teacher.contests.update');
    Route::delete('/teacher/contests/{contest}/delete', [TeacherController::class, 'deleteContest'])->name('teacher.contests.delete');

    Route::get('/teacher/problems/create', [TeacherController::class, 'createProblem'])->name('teacher.problems.create');
    Route::post('/teacher/problems/store', [TeacherController::class, 'storeProblem'])->name('teacher.problems.store');
    Route::get('/teacher/problems/{problem}/edit', [TeacherController::class, 'editProblem'])->name('teacher.problems.edit');
    Route::post('/teacher/problems/{problem}/update', [TeacherController::class, 'updateProblem'])->name('teacher.problems.update');
    Route::delete('/teacher/problems/{problem}/delete', [TeacherController::class, 'deleteProblem'])->name('teacher.problems.delete');
});
// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/{user}', [UserProfileController::class, 'show'])->name('profile.show');
    // Problems
    Route::get('/problems', [ProblemController::class, 'index'])->name('problems.index');
    Route::get('/problems/{id}', [ProblemController::class, 'show'])->name('problems.show');
    Route::post('/problems/{id}/submit', [ProblemController::class, 'submit'])->name('problems.submit');

    // Contests (For Everyone)
    Route::get('/contests', [ContestController::class, 'index'])->name('contests.index');
    Route::get('/contests/{contest}', [ContestController::class, 'show'])->name('contests.show');
    Route::get('/contests/{contest}/problems/{problem}', [ContestController::class, 'solve'])->name('contests.solve');
    Route::get('/contests/{contest}/leaderboard', [ContestController::class, 'leaderboard'])->name('contests.leaderboard');

    //Comment
    Route::post('/problems/{problem}/comments', [CommentController::class, 'store'])->middleware('auth')->name('comments.store');
    // Submitting Code for Contest Problems
    Route::post('/contests/{contest}/problems/{problem}/submit', [ContestSubmissionController::class, 'submit'])->name('contests.submit');
});

// Student-Specific Routes
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/dashboard', function () {
        return view('student.dashboard');
    });
});

require __DIR__ . '/auth.php';
