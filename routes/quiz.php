<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;


Route::middleware('auth')->group(function () {
	Route::get('/quiz/create', [QuizController::class, 'create'])
		->name('quiz.create');
	
	Route::post('/quiz/create', [QuizController::class, 'store'])
		->name('quiz.store');
	
	Route::get('/quiz/{id}/edit', [QuizController::class, 'edit'])
		->name('quiz.edit');

	Route::get('/quiz/{id}/take', function ($id) {
		return view('quiz.take', ['id' => $id]);
	})->name('quiz.take');
	
	Route::get('/quiz/my-quizzes', [QuizController::class, 'myQuizzes'])
		->name('quiz.my-quizzes');
	
	
	Route::post('/quiz/{id}/submit', function ($id) {
		// Logic to submit and validate the quiz
		return redirect()->route('quiz.results', ['id' => $id]);
	})->name('quiz.submit');
	
	Route::get('/quiz/{id}/results', function ($id) {
		return view('quiz.results', ['id' => $id]);
	})->name('quiz.results');
});