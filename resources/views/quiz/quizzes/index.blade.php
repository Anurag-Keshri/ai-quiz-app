@extends('layouts.app', ['navTitle' => 'My Quizzes'])

@php
	// TODO: Cache/Preload these values
	$questionCount = 0;
	$attemptCount = 0;
	foreach ($quizzes as $quiz) {
		$questionCount += $quiz->questions->count(); 
		$attemptCount += $quiz->attempts->count();
	}
@endphp

@section('content')
<div class="container mx-auto p-4">
    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="stats shadow bg-base-200">
            <div class="stat">
                <div class="stat-title">Total Quizzes</div>
                <div class="stat-value">{{ $quizzes->count() }}</div>
                <div class="stat-desc">Your created quizzes</div>
            </div>
        </div>
        
        <div class="stats shadow bg-base-200">
            <div class="stat">
                <div class="stat-title">Total Questions</div>
                <div class="stat-value">{{ $questionCount }}</div>
                <div class="stat-desc">Across all quizzes</div>
            </div>
        </div>

        <div class="stats shadow bg-base-200">
            <div class="stat">
                <div class="stat-title">Total Attempts</div>
                <div class="stat-value">{{ $attemptCount }}</div>
                <div class="stat-desc">By all users</div>
            </div>
        </div>
    </div>

    <!-- Quizzes Table -->
    @if($quizzes->isEmpty())
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body items-center text-center">
                <h2 class="card-title text-2xl mb-4">No Quizzes Yet</h2>
                <p class="mb-4">Get started by creating your first quiz!</p>
                <a href="{{ route('quizzes.create') }}" class="btn btn-primary">Create Quiz</a>
            </div>
        </div>
    @else
		@include('quiz.quizzes.partials.quizzes-table')
    @endif
</div>
@endsection