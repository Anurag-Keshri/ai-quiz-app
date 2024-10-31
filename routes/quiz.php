<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Quiz\QuizController;
use App\Http\Controllers\Quiz\QuizRuleController;
use App\Http\Controllers\Quiz\QuestionController;
use App\Http\Controllers\Quiz\AttemptController;

Route::middleware('auth')->group(function () {
	Route::get('/quizzes', [QuizController::class, 'index'])
		->name('quizzes.index');
	
	Route::get('/quizzes/create', [QuizController::class, 'create'])
		->name('quizzes.create');

	Route::post('/quizzes', [QuizController::class, 'store'])
		->name('quizzes.store');

	Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])
		->name('quizzes.show');

	Route::get('/quizzes/{quiz}/edit', [QuizController::class, 'edit'])
		->name('quizzes.edit');

	Route::put('/quizzes/{quiz}', [QuizController::class, 'update'])
		->name('quizzes.update');

	Route::delete('/quizzes/{quiz}', [QuizController::class, 'destroy'])
		->name('quizzes.destroy');

	Route::get('/quizzes/{quiz}/rules', [QuizRuleController::class, 'show'])
		->name('quiz_rules.show');

	Route::get('/quizzes/{quiz}/rules/edit', [QuizRuleController::class, 'edit'])
		->name('quiz_rules.edit');

	Route::put('/quizzes/{quiz}/rules', [QuizRuleController::class, 'update'])
		->name('quiz_rules.update');

	Route::get('/quizzes/{quiz}/questions/create', [QuestionController::class, 'create'])
		->name('questions.create');
	
	Route::get('/quizzes/{quiz}/questions/{question}', [QuestionController::class, 'show'])
		->name('questions.show');

	Route::post('/quizzes/{quiz}/questions', [QuestionController::class, 'store'])
		->name('questions.store');

	Route::get('/quizzes/{quiz}/questions/{question}/edit', [QuestionController::class, 'edit'])
		->name('questions.edit');

	Route::put('/quizzes/{quiz}/questions/{question}', [QuestionController::class, 'update'])
		->name('questions.update');

	Route::delete('/quizzes/{quiz}/questions/{question}', [QuestionController::class, 'destroy'])
		->name('questions.destroy');

	Route::get('/attempts', [AttemptController::class, 'index'])
		->name('attempts.index');
	
	Route::get('/quizzes/{quiz}/attempts', [AttemptController::class, 'index'])
		->name('attempts.index');

	Route::get('/quizzes/{quiz}/attempts/create', [AttemptController::class, 'create'])
		->name('attempts.create');

	Route::post('/quizzes/{quiz}/attempts', [AttemptController::class, 'store'])
		->name('attempts.store');

	Route::get('/quizzes/{quiz}/attempts/{attempt}', [AttemptController::class, 'show'])
		->name('attempts.show');

	Route::delete('/quizzes/{quiz}/attempts/{attempt}', [AttemptController::class, 'destroy'])
		->name('attempts.destroy');

	Route::post('/quizzes/{quiz}/attempts/{attempt}/submit', [AttemptController::class, 'submit'])
		->name('attempts.submit');
	
	Route::fallback(function () {
		abort(404);
	});
});
