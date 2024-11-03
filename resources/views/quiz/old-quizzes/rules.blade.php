@extends('layouts.app', ['navTitle' => 'Update Quiz Rules'])

@section('header')
    <h1 class="text-2xl font-bold">Update Quiz Rules</h1>
@endsection

@section('content')
    <div class="flex flex-col items-center justify-center p-4">
        <div class="flex justify-between items-center w-full max-w-md bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 rounded-lg p-4 mt-2">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Quiz Title: {{ $quiz->title }}</h2>
            <p class="text-gray-700 dark:text-gray-300">Quiz ID: {{ $quiz->id }}</p>
        </div>
        <div class="w-full max-w-md bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 rounded-lg p-4 mt-2">
            <form action="{{ route('quiz.update.rules', $quiz->id) }}" method="POST" id="quizRulesForm" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Time Limit -->
                <div class="mb-4">
                    <x-input-label for="time_limit" :value="__('Time Limit (Minutes):')" />
                    <input type="number" id="time_limit" name="time_limit" min="1" value="{{ $quiz->rules->time_limit }}" class="block w-full mt-1 p-2 border border-gray-700 rounded-lg dark:bg-gray-700 dark:text-gray-200">
                </div>

                <!-- Shuffle Questions (Toggle) -->
                <div class="mb-4 flex items-center justify-between">
                    <x-input-label for="shuffle_questions" :value="__('Shuffle Questions:')" class="flex-shrink-0 mr-2" />
                    <label for="shuffle_questions" class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="shuffle_questions" name="shuffle_questions" value="true" {{ $quiz->rules->shuffle_questions ? 'checked' : '' }} class="sr-only peer">
                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <!-- Shuffle Options (Toggle) -->
                <div class="mb-4 flex items-center justify-between">
                    <x-input-label for="shuffle_options" :value="__('Shuffle Options:')" class="flex-shrink-0 mr-2" />
                    <label for="shuffle_options" class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="shuffle_options" name="shuffle_options" value="true" {{ $quiz->rules->shuffle_options ? 'checked' : '' }} class="sr-only peer">
                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <!-- Show Score (Toggle) -->
                <div class="mb-4 flex items-center justify-between">
                    <x-input-label for="show_score" :value="__('Show Score:')" class="flex-shrink-0 mr-2" />
                    <label for="show_score" class="inline-flex items-center cursor-pointer">	
                        <input type="checkbox" id="show_score" name="show_score" value="true" {{ $quiz->rules->show_score ? 'checked' : '' }} class="sr-only peer">
                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <!-- Show Correct Answer (Toggle) -->
                <div class="mb-4 flex items-center justify-between">
                    <x-input-label for="show_correct_answer" :value="__('Show Correct Answer:')" class="flex-shrink-0 mr-2" />
                    <label for="show_correct_answer" class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="show_correct_answer" name="show_correct_answer" value="true" {{ $quiz->rules->show_correct_answer ? 'checked' : '' }} class="sr-only peer">
                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <!-- Start and End Date & Time -->
                <div class="mb-4">
                    <x-input-label for="start_date" :value="__('Start Date & Time:')" />
                    <input type="datetime-local" id="start_date" name="start_date" value="{{ $quiz->rules->start_date }}" class="block w-full mt-1 p-2 border border-gray-700 rounded-lg dark:bg-gray-700 dark:text-gray-200">
                </div>

                <div class="mb-4">
                    <x-input-label for="end_date" :value="__('End Date & Time:')" />
                    <input type="datetime-local" id="end_date" name="end_date" value="{{ $quiz->rules->end_date }}" class="block w-full mt-1 p-2 border border-gray-700 rounded-lg dark:bg-gray-700 dark:text-gray-200">
                </div>

                <!-- Submit Button -->
                <div class="mb-4">
                    <x-primary-button class="w-full">
                        Update Quiz Rules
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
@endsection
