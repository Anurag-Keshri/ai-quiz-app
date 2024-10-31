@extends('layouts.app')

@section('content')
	<div class="max-w-2xl mx-auto p-4">
        <div class="space-y-4">
            <!-- Time Limit -->
            <div>
                <h2 class="font-semibold">Time Limit</h2>
                <p>{{ $quizRules->time_limit ? "{$quizRules->time_limit} minutes" : 'No time limit' }}</p>
            </div>

            <!-- Quiz Settings -->
            <div>
                <h2 class="font-semibold">Quiz Settings</h2>
                <ul class="mt-2 space-y-1">
                    <li>
                        <span class="inline-block w-6">
                            {!! $quizRules->show_score ? '✓' : '✗' !!}
                        </span>
                        Show Score
                    </li>
                    <li>
                        <span class="inline-block w-6">
                            {!! $quizRules->shuffle_options ? '✓' : '✗' !!}
                        </span>
                        Shuffle Options
                    </li>
                    <li>
                        <span class="inline-block w-6">
                            {!! $quizRules->shuffle_questions ? '✓' : '✗' !!}
                        </span>
                        Shuffle Questions
                    </li>
                    <li>
                        <span class="inline-block w-6">
                            {!! $quizRules->show_correct_answer ? '✓' : '✗' !!}
                        </span>
                        Show Correct Answer
                    </li>
                </ul>
            </div>

            <!-- Availability -->
            <div>
                <h2 class="font-semibold">Availability</h2>
                <div class="mt-2 space-y-1">
                    <p>
                        <span class="font-medium">Starts:</span>
                        {{ $quizRules->start_date ? $quizRules->start_date->format('M d, Y H:i') : 'No start date set' }}
                    </p>
                    <p>
                        <span class="font-medium">Ends:</span>
                        {{ $quizRules->end_date ? $quizRules->end_date->format('M d, Y H:i') : 'No end date set' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection