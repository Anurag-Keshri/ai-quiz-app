<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Quiz\QuizController;
use App\Http\Controllers\Quiz\AttemptController;

Route::middleware('auth')->group(function () {
	// Quiz
	Route::prefix('quizzes')->name('quizzes.')->group(function () {
		Route::get('/', [QuizController::class, 'index'])->name('index');
		Route::post('/', [QuizController::class, 'store'])->name('store');
		Route::get('/create', [QuizController::class, 'create'])->name('create');
		Route::get('/{quiz}', [QuizController::class, 'show'])->name('show');
		Route::put('/{quiz}', [QuizController::class, 'update'])->name('update');
		Route::delete('/{quiz}', [QuizController::class, 'destroy'])->name('destroy');
		Route::get('/{quiz}/edit', [QuizController::class, 'edit'])->name('edit');
	});

	// Attempts (Quiz Attempts)
	Route::prefix('quizzes/{quiz}')->name('attempts.')->group(function () {
		Route::get('/attempts', [AttemptController::class, 'index'])->name('indexForQuiz');
		Route::get('/attempts/create', [AttemptController::class, 'create'])->name('create');
		Route::post('/attempts', [AttemptController::class, 'store'])->name('store');
		Route::get('/attempts/{attempt}', [AttemptController::class, 'show'])->name('show');
		Route::delete('/attempts/{attempt}', [AttemptController::class, 'destroy'])->name('destroy');
		Route::post('/attempts/{attempt}/submit', [AttemptController::class, 'submit'])->name('submit');
	});

	// Attempts (User Attempts)
	Route::prefix('attempts')->name('attempts.')->group(function () {
		Route::get('/', [AttemptController::class, 'index'])->name('index');
	});
	
	Route::fallback(function () {
		abort(404);
	});
});
