<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Quiz\QuizController;
use App\Http\Controllers\Quiz\QuizRuleController;
use App\Http\Controllers\Quiz\QuestionController;
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

	// Quiz Rules
	Route::prefix('quizzes/{quiz}')->name('quiz_rules.')->group(function () {
		Route::get('/rules', [QuizRuleController::class, 'show'])->name('show');
		Route::put('/rules', [QuizRuleController::class, 'update'])->name('update');
		Route::get('/rules/edit', [QuizRuleController::class, 'edit'])->name('edit');
	});
	
	// Questions
	Route::prefix('quizzes/{quiz}')->name('questions.')->group(function () {
		Route::post('/questions', [QuestionController::class, 'store'])->name('store');
		Route::get('/questions/create', [QuestionController::class, 'create'])->name('create');
		Route::get('/questions/{question}', [QuestionController::class, 'show'])->name('show');
		Route::put('/questions/{question}', [QuestionController::class, 'update'])->name('update');
		Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('destroy');
		Route::get('/questions/{question}/edit', [QuestionController::class, 'edit'])->name('edit');
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
