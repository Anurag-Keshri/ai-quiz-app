<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])
	->name('landing');

require __DIR__.'/auth.php';
require __DIR__.'/profile.php';
require __DIR__.'/quiz.php';