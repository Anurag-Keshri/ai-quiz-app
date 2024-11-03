<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Quiz;
use App\Models\Attempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
		$totalQuizzes = Quiz::count();
		$totalAttempts = Attempt::count();
		$totalUsers = User::count();
		$quizzes = [];
		$authUserQuizzes = [];

		if (Auth::check()) {
			$quizzes = Quiz::latest()->take(5)->get();
			$authUserQuizzes = Auth::user()->quizzes;
		}

        return view('home.index', compact('totalQuizzes', 'totalUsers', 'totalAttempts', 'quizzes', 'authUserQuizzes'));
    }
}
