@extends('layouts.app', ['navTitle' => 'Edit Quiz'])

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('quizzes.update', $quiz) }}" method="POST" id="quizForm">
                    @csrf
                    @method('PUT')
                    
                    <!-- Quiz Details Section -->
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">Quiz Details</h2>
                        <div class="space-y-4">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                                <input type="text" name="title" id="title" 
                                    value="{{ old('title', $quiz->title) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                <textarea name="description" id="description" rows="3" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $quiz->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Questions Section -->
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Questions</h2>
                            <button type="button" onclick="addQuestion()" 
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                Add Question
                            </button>
                        </div>

                        <div id="questions-container" class="space-y-6">
                            @foreach($quiz->questions as $index => $question)
                                <div class="question-block bg-gray-50 dark:bg-gray-700 p-4 rounded-lg" data-question-id="{{ $question->id }}">
                                    <div class="flex justify-between items-start mb-4">
                                        <input type="hidden" name="questions[{{ $index }}][id]" value="{{ $question->id }}">
                                        
                                        <div class="flex-grow mr-4">
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Question Text</label>
                                            <input type="text" 
                                                name="questions[{{ $index }}][question_text]" 
                                                value="{{ $question->question_text }}"
                                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                        </div>
                                        
                                        <button type="button" onclick="removeQuestion(this)" 
                                            class="text-red-600 hover:text-red-800">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="options-container space-y-3">
                                        @foreach($question->options as $optionIndex => $option)
                                            <div class="option-block flex items-center space-x-3">
                                                <input type="hidden" name="questions[{{ $index }}][options][{{ $optionIndex }}][id]" value="{{ $option->id }}">
                                                
                                                <input type="text" 
                                                    name="questions[{{ $index }}][options][{{ $optionIndex }}][option_text]" 
                                                    value="{{ $option->option_text }}"
                                                    class="flex-grow rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                                
                                                <input type="radio" 
                                                    name="questions[{{ $index }}][correct_option]" 
                                                    value="{{ $optionIndex }}"
                                                    {{ $option->is_correct ? 'checked' : '' }}
                                                    class="h-4 w-4 text-indigo-600">
                                                
                                                <button type="button" onclick="removeOption(this)" 
                                                    class="text-red-600 hover:text-red-800">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>

                                    <button type="button" onclick="addOption(this)" 
                                        class="mt-2 text-sm text-indigo-600 hover:text-indigo-800">
                                        + Add Option
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 text-right">
                        <button type="submit" 
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript for Dynamic Form Handling -->
    <script>
        let questionCounter = {{ count($quiz->questions) }};
        
        function addQuestion() {
            const template = `
                <div class="question-block bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-grow mr-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Question Text</label>
                            <input type="text" 
                                name="questions[${questionCounter}][question_text]" 
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                        </div>
                        <button type="button" onclick="removeQuestion(this)" 
                            class="text-red-600 hover:text-red-800">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                    <div class="options-container space-y-3">
                    </div>
                    <button type="button" onclick="addOption(this)" 
                        class="mt-2 text-sm text-indigo-600 hover:text-indigo-800">
                        + Add Option
                    </button>
                </div>
            `;
            
            document.getElementById('questions-container').insertAdjacentHTML('beforeend', template);
            questionCounter++;
        }

        function addOption(button) {
            const questionBlock = button.closest('.question-block');
            const optionsContainer = questionBlock.querySelector('.options-container');
            const optionCount = optionsContainer.children.length;
            const questionIndex = Array.from(questionBlock.parentNode.children).indexOf(questionBlock);

            const template = `
                <div class="option-block flex items-center space-x-3">
                    <input type="text" 
                        name="questions[${questionIndex}][options][${optionCount}][option_text]" 
                        class="flex-grow rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                    
                    <input type="radio" 
                        name="questions[${questionIndex}][correct_option]" 
                        value="${optionCount}"
                        class="h-4 w-4 text-indigo-600">
                    
                    <button type="button" onclick="removeOption(this)" 
                        class="text-red-600 hover:text-red-800">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            `;
            
            optionsContainer.insertAdjacentHTML('beforeend', template);
        }

        function removeQuestion(button) {
            if (confirm('Are you sure you want to remove this question?')) {
                button.closest('.question-block').remove();
            }
        }

        function removeOption(button) {
            if (confirm('Are you sure you want to remove this option?')) {
                button.closest('.option-block').remove();
            }
        }
    </script>
@endsection