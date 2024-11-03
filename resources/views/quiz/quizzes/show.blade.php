@extends('layouts.app', ['navTitle' => 'View Quiz'])

@section('content')
<div class="min-h-screen bg-base-200">
    <div class="container mx-auto p-4">
        <!-- Quiz Header -->
        <div class="card bg-base-100 shadow-xl mb-8 border border-base-300">
            <div class="card-body">
                <div class="flex flex-col md:flex-row justify-between gap-6">
                    <!-- Quiz Info -->
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold mb-4">{{ $quiz->title }}</h1>
                        <p class="text-base-content/70 mb-4">{{ $quiz->description }}</p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <div class="badge badge-outline">{{ $quiz->questions->count() }} Questions</div>
                            @if($quiz->difficulty)
                                <div class="badge badge-{{ $quiz->difficulty === 'easy' ? 'success' : ($quiz->difficulty === 'medium' ? 'warning' : 'error') }}">
                                    {{ ucfirst($quiz->difficulty) }}
                                </div>
                            @endif
                            <div class="badge badge-outline">{{ $quiz->attempts->count() }} Attempts</div>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-base-content/70">
                            <div class="avatar">
                                <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center">
                                    {{ strtoupper(substr($quiz->author->name, 0, 1)) }}
                                </div>
                            </div>
                            <span>Created by {{ $quiz->author->name }}</span>
                            <span>•</span>
                            <span>{{ $quiz->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col items-center justify-center gap-3">
                        <a href="{{ route('attempts.create', $quiz) }}" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                            </svg>
                            Take Quiz
                        </a>
                        @can('update', $quiz)
                            <a href="{{ route('quizzes.edit', $quiz) }}" class="btn btn-outline">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                                Edit Quiz
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

		@php
			$totalAttempts = $quiz->attempts->count();
			$totalQuestions = $quiz->questions->count();
			$averageScore = round($quiz->attempts->avg('score'), 1);
			$averageScorePercentage = round($averageScore / $totalQuestions * 100, 1);
			$highestScore = $totalAttempts ?? $quiz->attempts->max('score');
			$highestScorePercentage = round($highestScore / $totalQuestions * 100, 1);
			$completionRate = $totalAttempts ?? round(($quiz->attempts->whereNotNull('completed_at')->count() / $totalAttempts) * 100, 1);
		@endphp

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="stats shadow bg-base-100 border border-base-300">
                <div class="stat">
                    <div class="stat-title">Average Score</div>
					@if($totalAttempts)
						<div class="stat-value">({{ $averageScore }}) : {{ $averageScorePercentage }}%</div>
						<div class="stat-desc">Based on {{ $totalAttempts }} attempts</div>
					@else
						<div class="stat-value text-sm">No attempts yet.</div>
					@endif
                </div>
            </div>

            <div class="stats shadow bg-base-100 border border-base-300">
                <div class="stat">
                    <div class="stat-title">Highest Score</div>
					@if($totalAttempts)
						<div class="stat-value">({{ $highestScore }}) : {{ $highestScorePercentage }}%</div>
						<div class="stat-desc">Best performance</div>
					@else
						<div class="stat-value text-sm">No attempts yet.</div>
					@endif
                </div>
            </div>

            <div class="stats shadow bg-base-100 border border-base-300">
                <div class="stat">
                    <div class="stat-title">Completion Rate</div>
					@if($totalAttempts)
						<div class="stat-value">({{ $totalAttempts }}) : {{ $completionRate }}%</div>
						<div class="stat-desc">Of quiz views</div>
					@else
						<div class="stat-value text-sm">No attempts yet.</div>
					@endif
                </div>
            </div>
        </div>

		@if(Gate::allows('update', $quiz))
			<!-- Questions Preview -->
			<div class="card bg-base-100 shadow-xl border border-base-300">
				<div class="card-body">
					<h2 class="card-title text-2xl mb-6">Questions Preview</h2>

					<div class="join join-vertical w-full">
						@foreach($quiz->questions as $question)
							<details tabindex="0" class="collapse collapse-arrow join-item border border-base-300">
								<summary class="collapse-title text-xl font-medium peer-checked:bg-secondary peer-checked:text-secondary-content">
									<div class="flex items-center gap-3">
										<span class="badge badge-primary">{{ $loop->iteration }}</span>
										{{ $question->question_text }}
									</div>
								</summary>
								<div class="collapse-content peer-checked:bg-secondary peer-checked:text-secondary-content">
									<div class="mt-4 space-y-3">
										@foreach($question->options as $option)
											<div class="flex items-center gap-3 p-4 rounded-lg {{ $option->is_correct ? 'bg-success/10 border border-success/20' : 'bg-base-200' }}">
												@if($option->is_correct)
													<div class="badge badge-success gap-2">
														<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
															<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
														</svg>
														Correct
													</div>
												@else
													<div class="badge badge-ghost gap-2">
														<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
															<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
														</svg>
														Incorrect
													</div>
												@endif
												<span class="flex-1">{{ $option->option_text }}</span>
											</div>
										@endforeach
									</div>
								</div>
							</details>
						@endforeach
					</div>
				</div>
			</div>

			<!-- Recent Attempts -->
			@if($quiz->attempts->isNotEmpty())
				<div class="card bg-base-100 shadow-xl mt-8 border border-base-300">
					<div class="card-body">
						<div class="flex justify-between items-center mb-6">
							<h2 class="card-title text-2xl">Recent Attempts</h2>
							<a href="{{ route('attempts.indexForQuiz', ['quiz' => $quiz->id]) }}" class="btn btn-outline btn-sm">
								View All
							</a>
						</div>

						<div class="overflow-x-auto">
							<table class="table table-zebra w-full">
								<thead>
									<tr>
										<th>User</th>
										<th>Score</th>
										<th>Date</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									@foreach($quiz->attempts->take(10) as $attempt)
										<tr>
											<td>
												<div class="font-bold">{{ $attempt->user->name }}</div>
												<div class="text-sm opacity-50">{{ $attempt->user->email }}</div>
											</td>
											<td>
												<div class="flex items-center gap-2">
													<progress class="progress progress-primary w-24" value="{{ $attempt->score }}" max="100"></progress>
													<span class="font-medium">{{ $attempt->score }}%</span>
												</div>
											</td>
											<td>
												<div class="text-sm">{{ $attempt->completed_at->format('M d, Y') }}</div>
												<div class="text-xs opacity-50">{{ $attempt->completed_at->diffForHumans() }}</div>
											</td>
											<td>
												<a href="{{ route('attempts.show', [$quiz, $attempt]) }}" class="btn btn-ghost btn-sm">View Results</a>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			@endif
		@endif
    </div>
</div>
@endsection