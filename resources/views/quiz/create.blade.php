@extends('layouts.app', ['navTitle' => 'Create Quiz'])

@section('header')
    <h1 class="text-2xl font-bold">Create a New Quiz</h1>
@endsection

@section('content')
    <div class="flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 rounded-lg p-4 mt-2">

			<div class="tabs">
				<ul class="flex border-b">
					<li class="mr-1">
						<a href="#" class="tab-link inline-block py-2 px-4 font-semibold rounded-t-lg" data-tab="tab1">Quiz Details</a>
					</li>
					<li class="mr-1">
						<a href="#" class="tab-link inline-block py-2 px-4 font-semibold rounded-t-lg" data-tab="tab2">Quiz Rules</a>
					</li>
				</ul>
			</div>
			
			

            <form action="/quiz/create" method="POST" id="quizForm" class="space-y-4">
                @csrf

                <!-- Tab 1: Quiz Details -->
                <div id="tab1" class="tab-content">
                    <!-- AI Model -->
                    <div hidden class="mb-4">
                        <x-input-label for="model" :value="__('Select AI Model:')" />
                        <select name="model" id="model" value="openai" required class="block w-full mt-1 p-2 border border-gray-700 rounded-lg dark:bg-gray-700 dark:text-gray-200">
                            <option value="openai">OpenAI</option>
                            <option value="gemini">Gemini</option>
                        </select>
                    </div>

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
                        <textarea id="topic" name="topic" rows="3" placeholder="Enter the topic or prompt for the quiz" required class="block w-full mt-1 p-2 border border-gray-700 rounded-lg dark:bg-gray-700 dark:text-gray-200"></textarea>
                    </div>

                    <!-- Next Button -->
                    <div class="mb-4">
                        <x-primary-button type="button" class="w-full" id="nextButton">
                            Next
                        </x-primary-button>
                    </div>
                </div>

                <!-- Tab 2: Quiz Rules -->
                <div id="tab2" class="tab-content hidden">
                    <!-- Time Limit -->
                    <div class="mb-4">
                        <x-input-label for="time_limit" :value="__('Time Limit (Minutes):')" />
                        <input type="number" id="time_limit" name="time_limit" min="1" value="30" class="block w-full mt-1 p-2 border border-gray-700 rounded-lg dark:bg-gray-700 dark:text-gray-200">
                    </div>
                    <!-- Shuffle Questions (Toggle) -->
                    <div class="mb-4 flex items-center justify-between">
                        <x-input-label for="shuffle_questions" :value="__('Shuffle Questions:')" class="flex-shrink-0 mr-2" />
                        <label for="shuffle_questions" class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="shuffle_questions" name="shuffle_questions" class="sr-only peer">
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <!-- Shuffle Options (Toggle) -->
                    <div class="mb-4 flex items-center justify-between">
                        <x-input-label for="shuffle_options" :value="__('Shuffle Options:')" class="flex-shrink-0 mr-2" />
                        <label for="shuffle_options" class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="shuffle_options" name="shuffle_options" class="sr-only peer">
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <!-- Show Results Immediately (Toggle) -->
                    <div class="mb-4 flex items-center justify-between">
                        <x-input-label for="show_results_immediately" :value="__('Show Results Immediately:')" class="flex-shrink-0 mr-2" />
                        <label for="show_results_immediately" class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="show_results_immediately" name="show_results_immediately" class="sr-only peer">
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <!-- Start and End Date & Time -->
                    <div class="mb-4">
                        <x-input-label for="start_datetime" :value="__('Start Date & Time:')" />
                        <input type="datetime-local" id="start_datetime" name="start_datetime" class="block w-full mt-1 p-2 border border-gray-700 rounded-lg dark:bg-gray-700 dark:text-gray-200">
                    </div>

                    <div class="mb-4">
                        <x-input-label for="end_datetime" :value="__('End Date & Time:')" />
                        <input type="datetime-local" id="end_datetime" name="end_datetime" class="block w-full mt-1 p-2 border border-gray-700 rounded-lg dark:bg-gray-700 dark:text-gray-200">
                    </div>

                    <!-- Submit Button -->
                    <div class="mb-4">
                        <x-primary-button class="w-full">
                            Create Quiz
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
		document.addEventListener('DOMContentLoaded', function() {
			const tabLinks = document.querySelectorAll('.tab-link');
			const tabContents = document.querySelectorAll('.tab-content');
			const nextButton = document.getElementById('nextButton');

			function switchTab(targetTab) {
				tabLinks.forEach(link => {
					if (link.getAttribute('data-tab') === targetTab) {
						// Active tab: Lighter background, darker text
						link.classList.add('bg-gray-100', 'dark:bg-gray-700', 'text-gray-900', 'dark:text-gray-100');
						link.classList.remove('bg-gray-200', 'dark:bg-gray-600', 'text-gray-500', 'dark:text-gray-400');
					} else {
						// Inactive tab: Darker background, lighter text
						link.classList.remove('bg-gray-100', 'dark:bg-gray-700', 'text-gray-900', 'dark:text-gray-100');
						link.classList.add('text-gray-500', 'dark:text-gray-400');
					}
				});

				// Show/Hide tab content
				tabContents.forEach(content => {
					content.classList.toggle('hidden', content.id !== targetTab);
				});
			}

			tabLinks.forEach(link => {
				link.addEventListener('click', function(event) {
					event.preventDefault();
					const targetTab = this.getAttribute('data-tab');
					switchTab(targetTab);
				});
			});

			nextButton.addEventListener('click', function(event) {
				event.preventDefault();
				switchTab('tab2');
			});

			// Initialize the first tab as active
			switchTab('tab1');
		});


    </script>



@endsection
