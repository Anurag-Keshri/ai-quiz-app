@extends('layouts.app', ['navTitle' => 'Quiz Results'])

@section('header')
    <h1 class="text-3xl font-bold text-center mb-6 text-gray-800 dark:text-gray-200">Quiz Results</h1>
@endsection

@section('content')
    <div class="container mx-auto p-4 space-y-6 max-w-3xl">
		<div class="flex justify-between items-center bg-white dark:bg-gray-800 rounded-lg p-6 shadow-md">
			<h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Thank you for completing the quiz!</h2>
			<x-secondary-button>
				<a href="{{ route('landing') }}">
					Back to Home
				</a>
			</x-secondary-button>
		</div>
		@if ($attempt->quiz->rules->show_score)	
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-md">
            <div class="flex justify-between items-center mb-4">
                <div class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                    Score: {{ round(($attempt->score / $attempt->quiz->questions->count()) * 100, 2) }}%
                </div>
                <div class="text-gray-600 dark:text-gray-400">
                    {{ $attempt->score }} out of {{ $attempt->quiz->questions->count() }} correct
                </div>
            </div>
            <div class="h-2 bg-blue-600 rounded" style="width: {{ round(($attempt->score / $attempt->quiz->questions->count()) * 100, 2) }}%;"></div>
        </div>
		@else

			<div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-md text-center">
				<svg class="w-16 h-16 mx-auto mb-4 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
				</svg>
				<p class="text-xl font-semibold text-gray-700 dark:text-gray-300">Score is hidden for this quiz</p>
				<p class="mt-2 text-gray-600 dark:text-gray-400">The quiz creator has chosen to keep the scores private.</p>
			
			</div>
		@endif
		@if ($attempt->quiz->rules->show_correct_answer)
			<div class="">
				<div class="space-y-6">
					@foreach ($attempt->answers as $index => $answer)
						<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
							<div class="p-4">
								<h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
									{{ $index + 1 }}: {{ $answer->option->question->question_text }}
								</h3>
								<div class="space-y-2 mt-2">
									@php
										$options = $answer->option->question->options;
									@endphp
									@foreach ($options as $option)
										<div class="p-3 rounded-md 
											{{ $option->is_correct ? 'bg-green-100 dark:bg-green-900 text-gray-800 dark:text-gray-100' : 
											($option->option_text === $answer->option->option_text ? 'bg-red-100 dark:bg-red-900 text-gray-800 dark:text-gray-100' : 'bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-300') }}">
											<div class="flex gap-2">
												{{ $option->option_text }}
												@if ($option->option_text === $answer->option->option_text)
													<span class="ml-2">
														@if ($option->is_correct)
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check">
																<circle cx="12" cy="12" r="10"/>
																<path d="m9 12 2 2 4-4"/>
															</svg>
														@else
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x">
																<circle cx="12" cy="12" r="10"/>
																<path d="m15 9-6 6"/>
																<path d="m9 9 6 6"/>
															</svg>
														@endif
													</span>
												@endif
											</div>
										</div>
									@endforeach
								</div>
								@if (!$answer->option->is_correct)
									<div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
										<strong>Correct answer:</strong> {{ $answer->option->question->options->where('is_correct', true)->first()->option_text }}
									</div>
								@endif
							</div>
						</div>
					@endforeach
				</div>
			</div>
		@else
			<div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-md text-center">
				<svg class="w-16 h-16 mx-auto mb-4 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
				</svg>
				<p class="text-xl font-semibold text-gray-700 dark:text-gray-300">Answers are hidden for this quiz</p>
				<p class="mt-2 text-gray-600 dark:text-gray-400">The quiz creator has chosen to keep the answers private.</p>
			</div>
		@endif
    </div>
@endsection
