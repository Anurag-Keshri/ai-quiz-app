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
        <div class="stats shadow bg-base-200">
            <div class="stat">
                <div class="stat-title">Total Attempts</div>
                <div class="stat-value">{{ $attempts->count() }}</div>
                <div class="stat-desc">{{ isset($quiz) ? 'For this quiz' : 'Across all quizzes' }}</div>
            </div>
        </div>
        
        <div class="stats shadow bg-base-200">
            <div class="stat">
                <div class="stat-title">Average Score</div>
                <div class="stat-value">{{ $averageScore }}%</div>
                <div class="stat-desc">Out of 100%</div>
            </div>
        </div>

        <div class="stats shadow bg-base-200">
            <div class="stat">
                <div class="stat-title">Questions</div>
                <div class="stat-value">{{ isset($quiz) ? $quiz->questions->count() : $totalQuestions }}</div>
                <div class="stat-desc">{{ isset($quiz) ? 'In this quiz' : 'Total answered' }}</div>
            </div>
        </div>
    </div>

    <!-- Actions Bar -->
    @if(!$attempts->isEmpty())
        <div class="flex flex-col sm:flex-row gap-4 justify-between items-center mb-6">
            <!-- Search and Filter -->
            <div class="join">
                <input disabled type="text" placeholder="In development..." class="input input-bordered join-item" />
                <select disabled class="select select-bordered join-item">
                    <option value="">In development...</option>
                </select>
            </div>
        </div>
    @endif

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
        <div class="bg-base-100 rounded-lg shadow">
            <table class="table table-zebra">
                <!-- Table Header -->
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Score</th>
                        <th>Completed</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                
                <!-- Table Body -->
                <tbody>
                    @foreach($attempts as $attempt)
                    <tr class="hover">
                        <td>
                            <div class="font-bold">{{ $attempt->user->name }}</div>
                            <div class="text-sm opacity-50">{{ $attempt->user->email }}</div>
                        </td>
                        <td class="min-w-[200px]">
                            <div class="flex items-center gap-2">
                                <progress class="progress progress-primary w-full" value="{{ $attempt->score }}" max="100"></progress>
                                <span class="text-sm font-medium">{{ $attempt->score }}%</span>
                            </div>
                        </td>
                        <td>
                            <div class="text-sm">{{ $attempt->completed_at->format('M d, Y') }}</div>
                            <div class="text-xs opacity-50">{{ $attempt->completed_at->diffForHumans() }}</div>
                        </td>
                        <td class="text-right">
                            <div class="join">
                                <a href="{{ route('attempts.show', [$attempt->quiz, $attempt]) }}" class="btn btn-sm join-item">View Results</a>
                                @if($attempt->user_id === auth()->id())
                                    <div class="dropdown dropdown-end">
                                        <label tabindex="0" class="btn btn-sm join-item">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                            </svg>
                                        </label>
                                        <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                            <li>
                                                <form action="{{ route('attempts.destroy', [$attempt->quiz, $attempt]) }}" method="POST" class="w-full">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-error w-full text-left">Delete Attempt</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $attempts->links() }}
        </div>
    @endif
</div>
@endsection