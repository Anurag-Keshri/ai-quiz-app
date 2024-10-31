@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto p-4">
        <div class="bg-gray-50 dark:bg-gray-800/80 rounded-lg shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-800 p-6">
            <div class="flex items-center space-x-3 mb-6">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                </svg>
                <h1 class="text-xl font-medium text-gray-900 dark:text-white">Edit Quiz Rules</h1>
            </div>

            <form method="POST" action="{{ route('quiz_rules.update', $quiz) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Time Limit -->
                <div class="space-y-2">
                    <label for="time_limit" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Time Limit (minutes)
                    </label>
                    <input type="number" 
                           name="time_limit" 
                           id="time_limit" 
                           value="{{ old('time_limit', $quizRules->time_limit) }}"
                           class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                </div>

                <!-- Quiz Settings -->
                <div class="space-y-4">
                    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Quiz Settings</h3>
                    <div class="space-y-3">
                        @foreach([
                            'show_score' => 'Show final score to students',
                            'shuffle_options' => 'Randomize answer options',
                            'shuffle_questions' => 'Randomize question order',
                            'show_correct_answer' => 'Show correct answers after submission'
                        ] as $key => $label)
                            <label class="relative flex items-start">
                                <div class="flex items-center h-5">
                                    <input type="checkbox"
                                           name="{{ $key }}"
                                           value="1"
                                           {{ old($key, $quizRules->$key) ? 'checked' : '' }}
                                           class="h-4 w-4 rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-blue-600 focus:ring-blue-500">
                                </div>
                                <div class="ml-3 text-sm">
                                    <span class="text-gray-600 dark:text-gray-400">{{ $label }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Date Fields -->
                <div class="space-y-4">
                    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Availability Period</h3>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div class="space-y-2">
                            <label for="start_date" class="block text-sm font-medium text-gray-600 dark:text-gray-400">
                                Start Date & Time
                            </label>
                            <input type="datetime-local"
                                   name="start_date"
                                   id="start_date"
                                   value="{{ old('start_date', $quizRules->start_date) }}"
                                   class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>

                        <div class="space-y-2">
                            <label for="end_date" class="block text-sm font-medium text-gray-600 dark:text-gray-400">
                                End Date & Time
                            </label>
                            <input type="datetime-local"
                                   name="end_date"
                                   id="end_date"
                                   value="{{ old('end_date', $quizRules->end_date) }}"
                                   class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-4">
                    <button type="submit" 
                            class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                        Update Rules
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
