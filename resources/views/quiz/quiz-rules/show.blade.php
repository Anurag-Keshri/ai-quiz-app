@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto p-4">
        <div class="space-y-4">
            <!-- Time Limit -->
            <div class="bg-gray-50 dark:bg-gray-800/80 rounded-lg shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-800 p-6">
                <div class="flex items-center space-x-3 mb-3">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">Time Limit</h2>
                </div>
                <p class="text-gray-600 dark:text-gray-300">{{ $quizRules->time_limit ? "{$quizRules->time_limit} minutes" : 'No time limit' }}</p>
            </div>

            <!-- Quiz Settings -->
            <div class="bg-gray-50 dark:bg-gray-800/80 rounded-lg shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-800 p-6">
                <div class="flex items-center space-x-3 mb-4">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">Quiz Settings</h2>
                </div>
                <ul class="space-y-3">
                    @foreach(['show_score' => 'Show Score', 
                             'shuffle_options' => 'Shuffle Options',
                             'shuffle_questions' => 'Shuffle Questions',
                             'show_correct_answer' => 'Show Correct Answer'] as $key => $label)
                        <li class="flex items-center">
                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full {{ $quizRules->$key ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400' : 'bg-rose-50 text-rose-600 dark:bg-rose-500/20 dark:text-rose-400' }}">
                                {!! $quizRules->$key ? '✓' : '✗' !!}
                            </span>
                            <span class="ml-3 text-gray-600 dark:text-gray-300">{{ $label }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Availability -->
            <div class="bg-gray-50 dark:bg-gray-800/80 rounded-lg shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-800 p-6">
                <div class="flex items-center space-x-3 mb-4">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">Availability</h2>
                </div>
                <div class="space-y-3">
                    <p class="flex items-center">
                        <span class="font-medium text-gray-700 dark:text-gray-200 w-16">Starts:</span>
                        <span class="text-gray-600 dark:text-gray-300">{{ $quizRules->start_date ? $quizRules->start_date->format('M d, Y H:i') : 'No start date set' }}</span>
                    </p>
                    <p class="flex items-center">
                        <span class="font-medium text-gray-700 dark:text-gray-200 w-16">Ends:</span>
                        <span class="text-gray-600 dark:text-gray-300">{{ $quizRules->end_date ? $quizRules->end_date->format('M d, Y H:i') : 'No end date set' }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection