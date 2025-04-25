<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
		try {
			$employees = Employee::all()->sortBy('salary');
		} catch (Exception $e) {
			return redirect('landing');
		}
        return view('employees', compact('employees'));
    }
}
