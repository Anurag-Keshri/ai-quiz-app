@extends('layouts.app', ['navTitle' => 'Quiz Responses'])

@section('content')  
    <div class="container mx-auto p-4 max-w-4xl">

	{{-- Quiz Summary Card --}}
	<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border dark:border-gray-700 p-6">
		<div class="border-b dark:border-gray-700 pb-4">
			<h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $quiz->title }}</h2>
		</div>
		<div class="pt-6">
			<div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
				{{-- Statistics Grid --}}
				<div class="space-y-4">
					<div class="flex items-center space-x-3">
						<div class="p-2 bg-blue-100 dark:bg-blue-900/50 rounded-lg">
							<svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
							</svg>
						</div>
						<div>
							<p class="text-sm text-gray-500 dark:text-gray-400">Total Questions</p>
							<p class="text-lg font-semibold text-blue-600 dark:text-blue-400">{{ $quiz->number_of_questions }}</p>
						</div>
					</div>

					<div class="flex items-center space-x-3">
						<div class="p-2 bg-purple-100 dark:bg-purple-900/50 rounded-lg">
							<svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
							</svg>
						</div>
						<div>
							<p class="text-sm text-gray-500 dark:text-gray-400">Total Responses</p>
							<p class="text-lg font-semibold text-purple-600 dark:text-purple-400">{{ $quiz->attempts->count() }}</p>
						</div>
					</div>
				</div>

				{{-- Average Score Card with Dynamic Colors --}}
				@php
					$totalScore = $quiz->attempts->sum('score');
					$totalAttempts = $quiz->attempts->count();
					$averageScore = $totalAttempts > 0 ? $totalScore / $totalAttempts : 0;
					$scorePercentage = $quiz->number_of_questions > 0 ? ($averageScore / $quiz->number_of_questions) * 100 : 0;
					
					// Define color classes based on score percentage
					if ($scorePercentage >= 80) {
						$scoreColorText = 'text-green-600 dark:text-green-400';
						$scoreColorBg = 'bg-green-100 dark:bg-green-900/50';
						$scoreColorProgress = 'bg-green-500 dark:bg-green-400';
						$iconColor = 'text-green-600 dark:text-green-400';
					} elseif ($scorePercentage >= 60) {
						$scoreColorText = 'text-yellow-600 dark:text-yellow-400';
						$scoreColorBg = 'bg-yellow-100 dark:bg-yellow-900/50';
						$scoreColorProgress = 'bg-yellow-500 dark:bg-yellow-400';
						$iconColor = 'text-yellow-600 dark:text-yellow-400';
					} else {
						$scoreColorText = 'text-red-600 dark:text-red-400';
						$scoreColorBg = 'bg-red-100 dark:bg-red-900/50';
						$scoreColorProgress = 'bg-red-500 dark:bg-red-400';
						$iconColor = 'text-red-600 dark:text-red-400';
					}
				@endphp
				
				<div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
					<div class="flex items-center justify-between">
						<div>
							<h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Average Score</h3>
							<div class="mt-1 flex items-baseline">
								<p class="text-3xl font-bold {{ $scoreColorText }}">
									{{ number_format($averageScore, 1) }}
								</p>
								<span class="ml-2 text-sm text-gray-500 dark:text-gray-400">
									out of {{ $quiz->number_of_questions }}
									<span class="ml-1">({{ number_format($scorePercentage, 1) }}%)</span>
								</span>
							</div>
						</div>
						<div class="p-3 {{ $scoreColorBg }} rounded-full">
							@if ($scorePercentage >= 80)
								<svg class="w-6 h-6 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
								</svg>
							@elseif ($scorePercentage >= 60)
								<svg class="w-6 h-6 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
								</svg>
							@else
								<svg class="w-6 h-6 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
								</svg>
							@endif
						</div>
					</div>
					<div class="mt-4">
						<div class="h-2 bg-gray-200 dark:bg-gray-600 rounded-full">
							<div class="h-2 {{ $scoreColorProgress }} rounded-full transition-all duration-500" 
								style="width: {{ $scorePercentage }}%"></div>
						</div>
					</div>
					<div class="mt-2 text-sm {{ $scoreColorText }}">
						@if ($scorePercentage >= 80)
							Excellent performance!
						@elseif ($scorePercentage >= 60)
							Good progress, room for improvement
						@else
							Needs improvement
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>




	{{-- Responses Table --}}
	<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border dark:border-gray-700 mt-8">
		<div class="p-4 border-b border-gray-200 dark:border-gray-700">
			<h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Quiz Responses</h3>
		</div>
		
		<div class="overflow-x-auto">
			<table class="w-full text-gray-800 dark:text-gray-200">
				<thead>
					<tr class="bg-gray-50 dark:bg-gray-700">
						<th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
							<div class="flex items-center space-x-2">
								<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
								</svg>
								<span>User</span>
							</div>
						</th>
						<th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
							<div class="flex items-center space-x-2">
								<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
								</svg>
								<span>Score</span>
							</div>
						</th>
						<th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
							<div class="flex items-center space-x-2">
								<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
								</svg>
								<span>Time Taken</span>
							</div>
						</th>
						<th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
							<div class="flex items-center space-x-2">
								<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
								</svg>
								<span>Completed At</span>
							</div>
						</th>
						<th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
							Actions
						</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-gray-200 dark:divide-gray-700">
					@forelse ($quiz->attempts as $attempt)
						<tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
							<td class="px-6 py-4">
								<div class="flex items-center">
									<div class="">
										<div class="text-sm font-medium text-gray-900 dark:text-gray-100">
											{{ $attempt->user->name }}
										</div>
									</div>
								</div>
							</td>
							<td class="px-6 py-4">
								@php
									$scorePercentage = ($attempt->score / $quiz->number_of_questions) * 100;
									$scoreColor = $scorePercentage >= 80 ? 'text-green-600 dark:text-green-400' : 
												($scorePercentage >= 60 ? 'text-yellow-600 dark:text-yellow-400' : 
												'text-red-600 dark:text-red-400');
								@endphp
								<div class="flex flex-col">
									<span class="text-sm font-medium {{ $scoreColor }}">
										{{ $attempt->score }} / {{ $quiz->number_of_questions }}
									</span>
									<div class="w-24">
										<div class="h-1.5 bg-gray-200 dark:bg-gray-700 rounded-full">
											<div class="h-1.5 rounded-full {{ str_replace('text', 'bg', $scoreColor) }}"
												style="width: {{ $scorePercentage }}%"></div>
										</div>
									</div>
								</div>
							</td>
							<td class="px-6 py-4">
								<span class="text-sm text-gray-600 dark:text-gray-300">
									{{ $attempt->created_at->diffForHumans() }}
								</span>
							</td>
							<td class="px-6 py-4">
								<span class="text-sm text-gray-600 dark:text-gray-300">
									{{ $attempt->created_at->format('M d, Y H:i') }}
								</span>
							</td>
							<td class="px-6 py-4">
								<button
									onclick="toggleAnswers('answers-{{ $attempt->id }}')"
									class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-colors"
								>
									<span class="flex items-center">
										<svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
										</svg>
										View Answers
									</span>
								</button>
							</td>
						</tr>
						<tr id="answers-{{ $attempt->id }}" class="hidden">
							<td colspan="5" class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50">
								<div class="space-y-6">
									@foreach ($attempt->quizAnswers as $answer)
										<div class="relative pl-4 {{ $answer->is_correct ? 'border-l-4 border-green-500' : 'border-l-4 border-red-500' }}">
											<div class="mb-2">
												<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $answer->is_correct ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400' }}">
													Question {{ $loop->iteration }}
												</span>
											</div>
											<p class="text-base font-medium text-gray-900 dark:text-gray-100 mb-2">
												{{ $answer->question->question_text }}
											</p>
											<div class="ml-4 space-y-2">
												<p class="text-sm text-gray-600 dark:text-gray-300">
													<span class="font-medium">Your answer:</span> 
													<span class="ml-1 {{ $answer->is_correct ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
														{{ json_decode($answer->question->options)[$answer->selected_answer] }}
													</span>
												</p>
												@if (!$answer->is_correct)
													<p class="text-sm text-gray-600 dark:text-gray-300">
														<span class="font-medium">Correct answer:</span>
														<span class="ml-1 text-green-600 dark:text-green-400">
															{{ json_decode($answer->question->options)[$answer->question->correct_answer] }}
														</span>
													</p>
												@endif
											</div>
										</div>
									@endforeach
								</div>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="5" class="px-6 py-8 text-center">
								<div class="flex flex-col items-center">
									<svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
									</svg>
									<p class="mt-2 text-gray-500 dark:text-gray-400">No responses for this quiz yet.</p>
								</div>
							</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>

	{{-- JavaScript for smooth toggling of answer details --}}
	<script>
		function toggleAnswers(id) {
			const element = document.getElementById(id);
			if (element.classList.contains('hidden')) {
				element.classList.remove('hidden');
				element.style.maxHeight = '0';
				requestAnimationFrame(() => {
					element.style.transition = 'max-height 0.5s ease-in-out';
					element.style.maxHeight = element.scrollHeight + 'px';
				});
			} else {
				element.style.maxHeight = '0';
				element.addEventListener('transitionend', function handler() {
					element.classList.add('hidden');
					element.style.maxHeight = null;
					element.removeEventListener('transitionend', handler);
				});
			}
		}
	</script>
@endsection
