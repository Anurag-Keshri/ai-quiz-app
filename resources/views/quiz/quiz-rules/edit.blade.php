@extends('layouts.app')

@section('content')
	<div class="max-w-2xl mx-auto p-4">
        <h1 class="text-xl mb-4">Edit Quiz Rules</h1>

        <form method="POST" action="{{ route('quiz_rules.update', $quiz) }}">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <!-- Time Limit -->
                <div>
                    <label for="time_limit" class="block mb-1">Time Limit (minutes)</label>
                    <input type="number" 
                           name="time_limit" 
                           id="time_limit" 
                           value="{{ old('time_limit', $quizRules->time_limit) }}"
                           class="w-full border rounded px-3 py-2">
                </div>

                <!-- Checkboxes -->
                <div class="space-y-2">
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="show_score" 
                                   value="1" 
                                   {{ old('show_score', $quizRules->show_score) ? 'checked' : '' }}
                                   class="mr-2">
                            Show Score
                        </label>
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="shuffle_options" 
                                   value="1" 
                                   {{ old('shuffle_options', $quizRules->shuffle_options) ? 'checked' : '' }}
                                   class="mr-2">
                            Shuffle Options
                        </label>
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="shuffle_questions" 
                                   value="1" 
                                   {{ old('shuffle_questions', $quizRules->shuffle_questions) ? 'checked' : '' }}
                                   class="mr-2">
                            Shuffle Questions
                        </label>
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="show_correct_answer" 
                                   value="1" 
                                   {{ old('show_correct_answer', $quizRules->show_correct_answer) ? 'checked' : '' }}
                                   class="mr-2">
                            Show Correct Answer
                        </label>
                    </div>
                </div>

                <!-- Date Fields -->
                <div>
                    <label for="start_date" class="block mb-1">Start Date</label>
                    <input type="datetime-local" 
                           name="start_date" 
                           id="start_date" 
                           value="{{ old('start_date', $quizRules->start_date) }}"
                           class="w-full border rounded px-3 py-2">
                </div>

                <div>
                    <label for="end_date" class="block mb-1">End Date</label>
                    <input type="datetime-local" 
                           name="end_date" 
                           id="end_date" 
                           value="{{ old('end_date', $quizRules->end_date) }}"
                           class="w-full border rounded px-3 py-2">
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" 
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Update Rules
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
