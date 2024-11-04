@extends('layouts.app')

@section('content')
<div class="min-h-[calc(100vh-73px)] bg-base-200 py-4">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto space-y-6">
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold">{{ $quiz->title }}</h1>
                    <p class="text-base-content/70">
                        @if($quiz->rules->end_date && now()->isAfter($quiz->rules->end_date))
                            This quiz has ended
                        @elseif($quiz->rules->start_date && now()->isBefore($quiz->rules->start_date))
                            This quiz hasn't started yet
                        @else
                            Ready to start the quiz?
                        @endif
                    </p>
                </div>
            </div>

            <!-- Quiz Info Card -->
            <div class="card bg-base-100 shadow-xl border border-base-300">
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Time Limit -->
                        <div class="flex items-center gap-3">
                            <div class="p-3 bg-primary/10 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <div class="font-medium">Time Limit</div>
                                <div class="text-sm text-base-content/70">
                                    {{ $quiz->rules->time_limit ? $quiz->rules->time_limit . ' minutes' : 'No time limit' }}
                                </div>
                            </div>
                        </div>

                        <!-- Questions Count -->
                        <div class="flex items-center gap-3">
                            <div class="p-3 bg-primary/10 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <div class="font-medium">Questions</div>
                                <div class="text-sm text-base-content/70">
                                    {{ $quiz->questions->count() }} questions
                                </div>
                            </div>
                        </div>

                        <!-- Quiz Status -->
                        <div class="flex items-center gap-3">
                            <div class="p-3 bg-primary/10 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="flex flex-col justify-center">
                                <div class="font-medium">Quiz Status</div>
                                <div class="text-sm text-base-content/70">
                                    @if($quiz->rules->end_date && now()->isAfter($quiz->rules->end_date))
                                        <span class="text-sm badge badge-error">Ended</span>
                                    @elseif($quiz->rules->start_date && now()->isBefore($quiz->rules->start_date))
                                        <span class="text-sm badge badge-warning">Not Started</span>
                                    @else
                                        <span class="text-sm badge badge-success">Active</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quiz Rules Card -->
            <div class="card bg-base-100 shadow-xl border border-base-300">
                <div class="card-body">
                    <h2 class="card-title text-lg mb-4">Quiz Rules</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach([
                            ['Show Score', 'You will see your score after submission', $quiz->rules->show_score],
                            ['Shuffle Questions', 'Questions appear in random order', $quiz->rules->shuffle_questions],
                            ['Shuffle Options', 'Answer options are randomized', $quiz->rules->shuffle_options],
                            ['Show Answers', 'Correct answers shown after completion', $quiz->rules->show_correct_answer]
                        ] as [$title, $description, $enabled])
                            <div class="flex items-start gap-3">
                                <div class="mt-1">
                                    @if($enabled)
                                        <div class="badge badge-success badge-sm gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                    @else
                                        <div class="badge badge-ghost badge-sm gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-medium">{{ $title }}</div>
                                    <div class="text-sm text-base-content/70">{{ $description }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Start Quiz Button -->
            <div class="flex justify-end">
                <form method="POST" action="{{ route('attempts.store', $quiz) }}" class="flex gap-2">
                    @csrf
					<a href="{{ route('landing') }}" class="btn btn-outline">
						Cancel
					</a>
					@if(
						(!$quiz->rules->start_date || now()->isAfter($quiz->rules->start_date)) && 
						(!$quiz->rules->end_date || now()->isBefore($quiz->rules->end_date))
					)
						<button type="submit" 
							class="btn btn-primary"
							onclick="return confirm('Are you ready to start the quiz? The timer will begin immediately.')">
							Start Quiz
                        </button>
					@endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection