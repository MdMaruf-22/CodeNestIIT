<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProblemController;
use App\Http\Controllers\ContestController;
use App\Http\Controllers\ContestSubmissionController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContestDiscussionController;
use App\Http\Controllers\StudentDashboardController;
use App\Models\Submission;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard Routes (Require Auth + Approval)
Route::middleware(['auth', 'approved'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Teacher-Specific Routes (Require Auth + Approval + Role: Teacher)
    Route::middleware(['role:teacher'])->group(function () {
        Route::get('/teacher/dashboard', function () {
            return view('teacher.dashboard');
        });

        // Contest Management
        Route::get('/contests/create', [ContestController::class, 'create'])->name('contests.create');
        Route::post('/contests/store', [ContestController::class, 'store'])->name('contests.store');

        // Test case management
        Route::get('/teacher/problems/{problem}/test-cases', [TeacherController::class, 'manageTestCases'])->name('teacher.test_cases');
        Route::post('/teacher/problems/{problem}/test-cases/store', [TeacherController::class, 'storeTestCase'])->name('teacher.test_cases.store');
        Route::delete('/teacher/test-cases/{testCase}/delete', [TeacherController::class, 'deleteTestCase'])->name('teacher.test_cases.delete');

        // Contest & Problem Management
        Route::get('/teacher/contests', [TeacherController::class, 'manageContests'])->name('teacher.contests');
        Route::get('/teacher/problems', [TeacherController::class, 'manageProblems'])->name('teacher.problems');

        Route::get('/teacher/contests/create', [TeacherController::class, 'createContest'])->name('teacher.contests.create');
        Route::post('/teacher/contests/store', [TeacherController::class, 'storeContest'])->name('teacher.contests.store');
        Route::get('/teacher/contests/{contest}/edit', [TeacherController::class, 'editContest'])->name('teacher.contests.edit');
        Route::post('/teacher/contests/{contest}/update', [TeacherController::class, 'updateContest'])->name('teacher.contests.update');
        Route::delete('/teacher/contests/{contest}/delete', [TeacherController::class, 'deleteContest'])->name('teacher.contests.delete');
        Route::get('/teacher/plagiarism-reports', [TeacherController::class, 'plagiarismReports'])->name('teacher.plagiarism_reports');
        
        Route::get('/teacher/problems/create', [TeacherController::class, 'createProblem'])->name('teacher.problems.create');
        Route::post('/teacher/problems/store', [TeacherController::class, 'storeProblem'])->name('teacher.problems.store');
        Route::get('/teacher/problems/{problem}/edit', [TeacherController::class, 'editProblem'])->name('teacher.problems.edit');
        Route::post('/teacher/problems/{problem}/update', [TeacherController::class, 'updateProblem'])->name('teacher.problems.update');
        Route::delete('/teacher/problems/{problem}/delete', [TeacherController::class, 'deleteProblem'])->name('teacher.problems.delete');

        // User Management
        Route::get('/teacher/approvals', [TeacherController::class, 'showApprovals'])->name('teacher.approvals');
        Route::post('/teacher/approve/{user}', [TeacherController::class, 'approveUser'])->name('teacher.approve');
        Route::post('/teacher/reject/{user}', [TeacherController::class, 'rejectUser'])->name('teacher.reject');
    });

    // Authenticated Routes (Require Approval)
    Route::middleware(['auth'])->group(function () {
        // Profile Management
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('/profile/{user}', [UserProfileController::class, 'show'])->name('profile.show');

        // Problems
        Route::get('/problems', [ProblemController::class, 'index'])->name('problems.index');
        Route::get('/problems/{id}', [ProblemController::class, 'show'])->name('problems.show');
        Route::post('/problems/{id}/submit', [ProblemController::class, 'submit'])->name('problems.submit');
        Route::post('/problems/{problem}/runCustom', [ProblemController::class, 'runCustom'])->name('problems.runCustom');

        // Contests
        Route::get('/contests', [ContestController::class, 'index'])->name('contests.index');
        Route::get('/contests/{contest}', [ContestController::class, 'show'])->name('contests.show');
        Route::get('/contests/{contest}/problems/{problem}', [ContestController::class, 'solve'])->name('contests.solve');
        Route::get('/contests/{contest}/leaderboard', [ContestController::class, 'leaderboard'])->name('contests.leaderboard');
        Route::get('/contests/{contest}/results', [ContestController::class, 'results'])->name('contests.results');

        // Comment System
        Route::post('/problems/{problem}/comments', [CommentController::class, 'store'])->name('comments.store');

        // Contest Submissions
        Route::post('/contests/{contest}/problems/{problem}/submit', [ContestSubmissionController::class, 'submit'])->name('contests.submit');

        //Dedicated contest discussion forum
        Route::get('/contests/{contest}/discussions', [ContestDiscussionController::class, 'index'])->name('contests.discussions');
        Route::post('/contests/{contest}/discussions', [ContestDiscussionController::class, 'store'])->name('contests.discussions.store');
        Route::get('/submissions/{submission}/code', function (Submission $submission) {
                return response()->json(['code' => $submission->code]);
            });
    });

    // Student-Specific Routes (Require Approval)
    Route::middleware(['role:student'])->group(function () {
        Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])
            ->name('student.dashboard');
    });
});

require __DIR__ . '/auth.php';
