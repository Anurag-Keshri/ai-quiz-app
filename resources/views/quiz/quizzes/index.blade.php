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
        <div class="stats shadow bg-base-100">
            <div class="stat">
                <div class="stat-title">Total Quizzes</div>
                <div class="stat-value">{{ $quizzes->count() }}</div>
                <div class="stat-desc">Your created quizzes</div>
            </div>
        </div>
        
        <div class="stats shadow bg-base-100">
            <div class="stat">
                <div class="stat-title">Total Questions</div>
                <div class="stat-value">{{ $questionCount }}</div>
                <div class="stat-desc">Across all quizzes</div>
            </div>
        </div>

        <div class="stats shadow bg-base-100">
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
		<!-- Actions Bar -->
		@if(!$quizzes->isEmpty())
		<div class="flex flex-col sm:flex-row gap-4 justify-between items-center mb-6">
			<!-- Search and Filter -->
			<div class="join">
				<button disabled class="btn join-item bg-base-100">Search In development...</button>
				<label class="btn join-item bg-base-100" x-data="{myQuizzes : false}" @click="$dispatch('notify', {myQuizzes})">
					<span x-show="!myQuizzes" class="text-xs">My Quizzes</span>
					<span x-show="myQuizzes" class="text-xs">All Quizzes</span>
					<input type="checkbox" class="toggle toggle-sm" x-model="myQuizzes" />
				</label>
			</div>

			<!-- Create New Quiz Button -->
			<div class="flex items-center gap-2">
				<a href="{{ route('quizzes.create') }}" class="btn btn-primary">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
					</svg>
					Create Quiz
				</a>
			</div>
		</div>
		@endif
		@include('quiz.quizzes.partials.quizzes-table')
    @endif
</div>
@endsection