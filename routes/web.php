<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	return view('landing');
})->name('landing');

Route::get('/dashboard', function () {
	return view('dashboard');
})->name('dashboard');

require __DIR__.'/auth.php';
require __DIR__.'/profile.php';
require __DIR__.'/quiz.php';