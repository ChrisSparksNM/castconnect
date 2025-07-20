<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActorSubmissionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TvShowController;
use App\Http\Controllers\LeaderboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// TV Shows - Public routes
Route::get('/tv-shows', [TvShowController::class, 'index'])->name('tv-shows.index');
Route::get('/tv-shows/{tvShow}', [TvShowController::class, 'show'])->name('tv-shows.show');
Route::get('/tv-shows/{tvShow}/feed', [TvShowController::class, 'feed'])->name('tv-shows.feed');
Route::get('/feed', [TvShowController::class, 'globalFeed'])->name('tv-shows.global-feed');

// Leaderboard - Public route
Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Actor submissions
    Route::get('/submit-actor', [ActorSubmissionController::class, 'create'])->name('actor-submissions.create');
    Route::post('/submit-actor', [ActorSubmissionController::class, 'store'])->name('actor-submissions.store');
    Route::get('/my-submissions', [ActorSubmissionController::class, 'index'])->name('actor-submissions.index');
    
    // TV Show submissions
    Route::get('/submit-show', [\App\Http\Controllers\TvShowSubmissionController::class, 'create'])->name('tv-show-submissions.create');
    Route::post('/submit-show', [\App\Http\Controllers\TvShowSubmissionController::class, 'store'])->name('tv-show-submissions.store');
    Route::get('/my-show-submissions', [\App\Http\Controllers\TvShowSubmissionController::class, 'index'])->name('tv-show-submissions.index');
    Route::get('/my-show-submissions/{tvShowSubmission}', [\App\Http\Controllers\TvShowSubmissionController::class, 'show'])->name('tv-show-submissions.show');
    
    // Admin routes
    Route::get('/admin/submissions', [AdminController::class, 'submissions'])->name('admin.submissions');
    Route::post('/admin/submissions/{submission}/approve', [AdminController::class, 'approveSubmission'])->name('admin.submissions.approve');
    Route::post('/admin/submissions/{submission}/reject', [AdminController::class, 'rejectSubmission'])->name('admin.submissions.reject');
    
    // Admin TV Show submissions
    Route::get('/admin/tv-show-submissions', [\App\Http\Controllers\TvShowSubmissionController::class, 'adminIndex'])->name('admin.tv-show-submissions');
    Route::post('/admin/tv-show-submissions/{tvShowSubmission}/approve', [\App\Http\Controllers\TvShowSubmissionController::class, 'approve'])->name('admin.tv-show-submissions.approve');
    Route::post('/admin/tv-show-submissions/{tvShowSubmission}/reject', [\App\Http\Controllers\TvShowSubmissionController::class, 'reject'])->name('admin.tv-show-submissions.reject');
});

require __DIR__.'/auth.php';
