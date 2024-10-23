@extends('layouts.app')

@section('header')
    <h1 class="text-3xl font-bold text-center mb-6 text-gray-800 dark:text-gray-200">Quiz Results</h1>
@endsection

@section('content')
    <div class="container mx-auto p-4 space-y-6 max-w-3xl">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-md">
            <div class="flex justify-between items-center mb-4">
                <div class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                    Score: {{ round(($quizAttempt->score / $quizAttempt->quiz->number_of_questions) * 100, 2) }}%
                </div>
                <div class="text-gray-600 dark:text-gray-400">
                    {{ $quizAttempt->score }} out of {{ $quizAttempt->quiz->number_of_questions }} correct
                </div>
            </div>
            <div class="h-2 bg-blue-600 rounded" style="width: {{ round(($quizAttempt->score / $quizAttempt->quiz->number_of_questions) * 100, 2) }}%;"></div>
        </div>

        <div class="">
            <div class="space-y-6">
                @foreach ($quizAttempt->quizAnswers as $index => $answer)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
                        <div class="p-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ $index + 1 }}: {{ $answer->question->question_text }}
                            </h3>
                            <div class="space-y-2 mt-2">
                                @php
                                    $options = json_decode($answer->question->options);
                                @endphp
                                @foreach ($options as $optionIndex => $option)
                                    <div class="p-3 rounded-md 
                                        {{ $option === $options[$answer->question->correct_answer] ? 'bg-green-100 dark:bg-green-900 text-gray-800 dark:text-gray-100' : 
                                           ($option === $options[$answer->selected_answer] ? 'bg-red-100 dark:bg-red-900 text-gray-800 dark:text-gray-100' : 'bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-300') }}">
                                        <div class="flex gap-2">
											{{ $option }}
											@if ($option === $options[$answer->selected_answer])
												<span class="ml-2">
													@if ($option === $options[$answer->question->correct_answer])
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
                            @if ($answer->selected_answer !== $answer->question->correct_answer)
                                <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                                    <strong>Correct answer:</strong> {{ $options[$answer->question->correct_answer] }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
