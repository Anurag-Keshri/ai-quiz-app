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

    <!-- Actions Bar -->
	@if(!$quizzes->isEmpty())
		<div class="flex flex-col sm:flex-row gap-4 justify-between items-center mb-6">
			<!-- Search and Filter -->
			<div class="join">
				<input disabled type="text" placeholder="In development..." class="input input-bordered join-item" />
				<select disabled class="select select-bordered join-item">
					<option value="">In development...</option>
				</select>
			</div>

			<!-- Create New Quiz Button -->
			<a href="{{ route('quizzes.create') }}" class="btn btn-primary">
				<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
				</svg>
				Create Quiz
			</a>
		</div>
	@endif
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
        <div class="bg-base-100 rounded-lg shadow">
            <table class="table table-zebra">
                <!-- Table Header -->
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Questions</th>
                        <th>Attempts</th>
                        <th>Created</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                
                <!-- Table Body -->
                <tbody>
                    @foreach($quizzes as $quiz)
                    <tr class="hover">
                        <td>
                            <div class="font-bold">{{ $quiz->title }}</div>
                            <div class="text-sm opacity-50">{{ Str::limit($quiz->description, 60) }}</div>
                        </td>
                        <td>
                            <div class="badge badge-ghost">{{ $quiz->questions->count() }}</div>
                        </td>
                        <td>
                            <div class="badge badge-ghost">{{ $quiz->attempts->count() }}</div>
                        </td>
                        <td>
                            <div class="text-sm">{{ $quiz->created_at->format('M d, Y') }}</div>
                            <div class="text-xs opacity-50">{{ $quiz->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="text-right">
                            <div class="join">
                                <a href="{{ route('quizzes.show', $quiz) }}" class="btn btn-sm join-item">View</a>
                                <a href="{{ route('attempts.create', $quiz) }}" class="btn btn-sm join-item">Take</a>
								<a href="{{ route('attempts.indexForQuiz', $quiz) }}" class="btn btn-sm join-item">Attempts</a>
								<div class="dropdown dropdown-end">
                                    <label tabindex="0" class="btn btn-sm join-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                        </svg>
                                    </label>
                                    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                        <li><a href="{{ route('quizzes.edit', $quiz) }}">Edit Quiz</a></li>
                                        <li><a href="{{ route('quiz_rules.edit', $quiz) }}">Edit Rules</a></li>
                                        <li>
                                            <form action="{{ route('quizzes.destroy', $quiz) }}" method="POST" class="w-full">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-error w-full text-left">Delete Quiz</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $quizzes->links() }}
        </div>
    @endif
</div>
@endsection