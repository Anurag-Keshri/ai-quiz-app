<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmployeeController;

Route::get('/', [HomeController::class, 'index'])
	->name('landing');

require __DIR__.'/auth.php';
require __DIR__.'/profile.php';
require __DIR__.'/quiz.php';
require __DIR__.'/employee.php';

