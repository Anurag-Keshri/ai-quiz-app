@extends('layouts.app', ['navTitle' => 'Create Quiz'])

@section('header')
    <h1 class="text-2xl font-bold">Create a New Quiz</h1>
@endsection

@section('content')
    <div class="flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 rounded-lg p-4 mt-2">


			
			

            <form action="{{ route('quizzes.store') }}" method="POST" id="quizForm" class="space-y-4">
                @csrf

                <div id="tab1" class="tab-content">
                    <!-- Number of Questions and Options -->
                    <div class="mb-4 flex space-x-4">
                        <div class="flex-1">
                            <x-input-label for="questions" :value="__('Number of Questions:')" />
                            <input type="number" id="questions" name="number_of_questions" min="1" required value="10" class="block w-full mt-1 p-2 border border-gray-700 rounded-lg dark:bg-gray-700 dark:text-gray-200">
                        </div>
                        <div class="flex-1">
                            <x-input-label for="options" :value="__('Options per Question:')" />
                            <input type="number" id="options" name="number_of_options" min="2" required value="4" class="block w-full mt-1 p-2 border border-gray-700 rounded-lg dark:bg-gray-700 dark:text-gray-200">
                        </div>
                    </div>

                    <!-- Difficulty Level -->
                    <div class="mb-4">
                        <x-input-label for="difficulty" :value="__('Difficulty Level:')" />
                        <select name="difficulty" id="difficulty" required class="block w-full mt-1 p-2 border border-gray-700 rounded-lg dark:bg-gray-700 dark:text-gray-200">
                            <option value="easy">Easy</option>
                            <option value="medium">Medium</option>
                            <option value="hard">Hard</option>
                        </select>
                    </div>

                    <!-- Depth Level -->
                    <div class="mb-4">
                        <x-input-label for="depth" :value="__('Depth Level:')" />
                        <select name="depth" id="depth" required class="block w-full mt-1 p-2 border border-gray-700 rounded-lg dark:bg-gray-700 dark:text-gray-200">
                            <option value="shallow">Shallow</option>
                            <option value="deep">Deep</option>
                        </select>
                    </div>

                    <!-- Topic (Prompt) -->
                    <div class="mb-4">
                        <x-input-label for="topic" :value="__('Topic (Prompt):')" />
                        <textarea id="topic" name="topic" rows="3" placeholder="Enter the topic or prompt for the quiz"  class="block w-full mt-1 p-2 border border-gray-700 rounded-lg dark:bg-gray-700 dark:text-gray-200"></textarea>
                    </div>

                    <!-- Next Button -->
                    <div class="mb-4">
                        <x-primary-button type="submit" class="w-full" id="nextButton">
                            Next
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>




@endsection
