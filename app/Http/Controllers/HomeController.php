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
		$totalQuizzes = 0;
		$totalAttempts = 0;
		$totalUsers = 0;
		$recentQuizzes = [];
		$authUserQuizzes = [];

		// If user is logged in, get the total quizzes, attempts and users
		if (Auth::check()) {
			$totalQuizzes = Quiz::count();
			$totalAttempts = Attempt::count();
			$totalUsers = User::count();
			$recentQuizzes = Quiz::orderBy('created_at', 'desc')->take(5)->get();
			$authUserQuizzes = Auth::user()->quizzes;
		}

        return view('home.index', compact('totalQuizzes', 'totalUsers', 'totalAttempts', 'recentQuizzes', 'authUserQuizzes'));
    }
}
