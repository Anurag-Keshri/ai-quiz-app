@extends('layouts.app')

@php
	// TODO: Implement home controller to access these values
	$totalQuizzes = 0;
	$totalAttempts = 0;
	$totalUsers = 0;
	$recentQuizzes = [];
@endphp

@section('content')
<div class="min-h-screen bg-base-200">
    <!-- Hero Section -->
    <div class="hero min-h-[60vh] bg-base-100">
        <div class="hero-content text-center">
            <div class="max-w-3xl">
                <h1 class="text-5xl font-bold mb-8">Welcome to {{ config('app.name') }}</h1>
                <p class="text-xl mb-8 text-base-content/70">
                    Create and take AI-powered quizzes on any topic. Perfect for learning, teaching, or just having fun!
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        <a href="{{ route('quizzes.create') }}" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Create Quiz
                        </a>
                        <a href="{{ route('quizzes.index') }}" class="btn btn-outline">
                            Browse Quizzes
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            Get Started
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline">
                            Sign In
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
    <div class="container mx-auto px-4 py-12">
        <!-- Features Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <div class="card bg-base-100 shadow-xl border border-base-300">
                <div class="card-body items-center text-center">
                    <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                    </div>
                    <h2 class="card-title text-2xl mb-2">Create</h2>
                    <p class="text-base-content/70">
                        Generate custom quizzes powered by AI. Just provide a topic and let our system do the rest.
                    </p>
                </div>
            </div>

            <div class="card bg-base-100 shadow-xl border border-base-300">
                <div class="card-body items-center text-center">
                    <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h2 class="card-title text-2xl mb-2">Take</h2>
                    <p class="text-base-content/70">
                        Challenge yourself with quizzes on various topics. Track your progress and improve your knowledge.
                    </p>
                </div>
            </div>

            <div class="card bg-base-100 shadow-xl border border-base-300">
                <div class="card-body items-center text-center">
                    <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                        </svg>
                    </div>
                    <h2 class="card-title text-2xl mb-2">Share</h2>
                    <p class="text-base-content/70">
                        Share your quizzes with others and see how they perform. Perfect for teachers and study groups.
                    </p>
                </div>
            </div>
        </div>
		
		@auth
        <!-- Recent Quizzes Section -->
        <div class="mb-16">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold">Recent Quizzes</h2>
                <a href="{{ route('quizzes.index') }}" class="btn btn-outline btn-sm">
                    View All
                </a>
            </div>

            @if(count($recentQuizzes) === 0)
                <div class="card bg-base-100 shadow-xl border border-base-300">
                    <div class="card-body items-center text-center">
                        <h3 class="card-title text-2xl mb-4">No Quizzes Yet</h3>
                        <p class="mb-4">Be the first to create a quiz!</p>
                        <a href="{{ route('quizzes.create') }}" class="btn btn-primary">Create Quiz</a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($recentQuizzes as $quiz)
                        <div class="card bg-base-100 shadow-xl border border-base-300">
                            <div class="card-body">
                                <h3 class="card-title">{{ $quiz->title }}</h3>
                                <p class="text-base-content/70">{{ Str::limit($quiz->description, 100) }}</p>
                                <div class="flex gap-2 my-2">
                                    <div class="badge badge-outline">{{ $quiz->questions->count() }} Questions</div>
                                    @if($quiz->difficulty)
                                        <div class="badge badge-{{ $quiz->difficulty === 'easy' ? 'success' : ($quiz->difficulty === 'medium' ? 'warning' : 'error') }}">
                                            {{ ucfirst($quiz->difficulty) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="card-actions justify-end mt-4">
                                    <a href="{{ route('attempts.create', $quiz) }}" class="btn btn-primary btn-sm">Take Quiz</a>
                                    <a href="{{ route('quizzes.show', $quiz) }}" class="btn btn-ghost btn-sm">Learn More</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
		@endauth

        <!-- Stats Section -->
        <div class="stats shadow w-full border border-base-300">
            <div class="stat">
                <div class="stat-figure text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="stat-title">Total Quizzes</div>
                <div class="stat-value">{{ $totalQuizzes }}</div>
                <div class="stat-desc">Created by our users</div>
            </div>
            
            <div class="stat">
                <div class="stat-figure text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                    </svg>
                </div>
                <div class="stat-title">Active Users</div>
                <div class="stat-value">{{ $totalUsers }}</div>
                <div class="stat-desc">Learning together</div>
            </div>
            
            <div class="stat">
                <div class="stat-figure text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="stat-title">Quizzes Taken</div>
                <div class="stat-value">{{ $totalAttempts }}</div>
                <div class="stat-desc">And counting!</div>
            </div>
        </div>
    </div>
</div>
@endsection