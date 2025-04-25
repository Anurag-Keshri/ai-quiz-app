<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

// end-term-practical

Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');