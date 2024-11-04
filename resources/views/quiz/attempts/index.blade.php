@extends('layouts.app', ['navTitle' => isset($quiz) ? "Attempts for {$quiz->title}" : 'My Attempts'])

@php
    // TODO: Cache/Preload these values
    $totalQuestions = 0;
    $totalScore = 0;
    $averageScore = 0;
    
    foreach ($attempts as $attempt) {
        $totalQuestions += $attempt->quiz->questions->count();
        $totalScore += $attempt->score;
    }
    
    if ($attempts->count() > 0) {
        $averageScore = round($totalScore / $attempts->count());
    }
@endphp

@section('content')
<div class="container mx-auto p-4">
    @if(isset($quiz))
        <!-- Quiz Info Header -->
        <div class="card bg-base-100 shadow-xl mb-8">
            <div class="card-body">
                <div class="flex flex-col md:flex-row justify-between gap-4">
                    <!-- Quiz Details -->
                    <div>
                        <h2 class="card-title text-2xl mb-2">{{ $quiz->title }}</h2>
                        <p class="text-base-content/70 mb-4">{{ $quiz->description }}</p>
                        <div class="flex gap-2">
                            @if($quiz->difficulty)
                                <div class="badge badge-{{ $quiz->difficulty === 'easy' ? 'success' : ($quiz->difficulty === 'medium' ? 'warning' : 'error') }}">
                                    {{ ucfirst($quiz->difficulty) }}
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('attempts.create', $quiz) }}" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Take Quiz
                        </a>
                        <a href="{{ route('quizzes.show', $quiz) }}" class="btn btn-outline">View Quiz Details</a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="stats shadow bg-base-100">
            <div class="stat">
                <div class="stat-title">Total Attempts</div>
                <div class="stat-value">{{ $attempts->count() }}</div>
                <div class="stat-desc">{{ isset($quiz) ? 'For this quiz' : 'Across all quizzes' }}</div>
            </div>
        </div>
        
        <div class="stats shadow bg-base-100">
            <div class="stat">
                <div class="stat-title">Average Score</div>
                <div class="stat-value">{{ $averageScore }}%</div>
                <div class="stat-desc">Out of 100%</div>
            </div>
        </div>

        <div class="stats shadow bg-base-100">
            <div class="stat">
                <div class="stat-title">Questions</div>
                <div class="stat-value">{{ isset($quiz) ? $quiz->questions->count() : $totalQuestions }}</div>
                <div class="stat-desc">{{ isset($quiz) ? 'In this quiz' : 'Total answered' }}</div>
            </div>
        </div>
    </div>

    <!-- Attempts Table -->
    @if($attempts->isEmpty())
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body items-center text-center">
                <h2 class="card-title text-2xl mb-4">No Attempts Yet</h2>
                @if(isset($quiz))
                    <p class="mb-4">Be the first to take this quiz!</p>
                    <a href="{{ route('attempts.create', $quiz) }}" class="btn btn-primary">Take Quiz</a>
                @else
                    <p class="mb-4">You haven't attempted any quizzes yet!</p>
                    <a href="{{ route('quizzes.index') }}" class="btn btn-primary">Browse Quizzes</a>
                @endif
            </div>
        </div>
    @else
		@include('quiz.attempts.partials.attempts-table')
    @endif
</div>
@endsection