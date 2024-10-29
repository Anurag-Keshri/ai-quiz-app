<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Quiz\QuizController;


Route::middleware('auth')->group(function () {
	Route::get('/quiz/create', [QuizController::class, 'create'])
		->name('quiz.create');
	
	Route::post('/quiz/create', [QuizController::class, 'store'])
		->name('quiz.store');

	Route::get('/quiz/{id}/edit', [QuizController::class, 'edit'])
		->name('quiz.edit');

	Route::get('/quiz/{id}/view', [QuizController::class, 'show'])
		->name('quiz.view');

	Route::get('/quiz/{id}/take', [QuizController::class, 'take'])
		->name('quiz.take');

	Route::get('/quiz/{id}/rules', [QuizController::class, 'rules'])
		->name('quiz.rules');
	
	Route::put('/quiz/{id}/rules', [QuizController::class, 'updateRules'])
		->name('quiz.update.rules');
	
	Route::get('/quiz/my-quizzes', [QuizController::class, 'myQuizzes'])
		->name('quiz.my-quizzes');
	
	
	Route::post('/quiz/{id}/submit', [QuizController::class, 'submit'])
		->name('quiz.submit');

	
	Route::get('/quiz/{id}/result', [QuizController::class, 'showResults'])
		->name('quiz.result');

	Route::get('/quiz/{quiz}/responses', [QuizController::class, 'responses'])
		->name('quiz.responses');

	Route::delete('/quiz/{id}', [QuizController::class, 'destroy'])
		->name('quiz.destroy');
});
