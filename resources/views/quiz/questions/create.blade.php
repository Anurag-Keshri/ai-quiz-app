@extends('layouts.app')

@section('content')
<div class="min-h-[calc(100vh-73px)] bg-base-200 py-4">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto space-y-6">
            <form action="{{ route('questions.store', $quiz) }}" method="POST" class="space-y-6">
                @csrf

                <!-- Header Section -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                    <div>
                        <h1 class="text-2xl font-bold">Add New Question</h1>
                        <p class="text-base-content/70 text-sm">Creating question for: {{ $quiz->title }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('quizzes.show', $quiz) }}" 
                           class="btn btn-ghost btn-sm normal-case">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="btn btn-primary btn-sm normal-case px-6">
                            Create Question
                        </button>
                    </div>
                </div>

                <!-- Question Details Card -->
                <div class="card bg-base-100 shadow-xl border border-base-300">
                    <div class="card-body p-6">
                        <h2 class="card-title text-lg mb-6">Question Details</h2>
                        
                        <!-- Question Text -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Question Text</span>
                                <span class="label-text-alt text-base-content/70">Required</span>
                            </label>
                            <textarea name="question_text" 
                                      class="textarea textarea-bordered h-24 @error('question_text') textarea-error @enderror"
                                      placeholder="Enter your question here">{{ old('question_text') }}</textarea>
                            @error('question_text')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Answer Options Card -->
                <div class="card bg-base-100 shadow-xl border border-base-300">
                    <div class="card-body p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h2 class="card-title text-lg">Answer Options</h2>
                                <p class="text-sm text-base-content/70">Add at least 2 options and mark the correct answer</p>
                            </div>
                            <button type="button" 
                                    class="btn btn-ghost btn-sm gap-2"
                                    onclick="addOption()">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Add Option
                            </button>
                        </div>

                        <div id="options-container" class="space-y-4">
                            <!-- Initial two options -->
                            @for($i = 0; $i < 2; $i++)
                                <div class="option-item">
                                    <div class="flex items-start gap-4">
                                        <div class="flex-1">
                                            <div class="form-control">
                                                <input type="text" 
                                                       name="options[{{ $i }}][text]" 
                                                       class="input input-bordered @error('options.' . $i . '.text') input-error @enderror" 
                                                       value="{{ old('options.' . $i . '.text') }}"
                                                       placeholder="Enter option {{ $i + 1 }}" />
                                                @error('options.' . $i . '.text')
                                                    <label class="label">
                                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                                    </label>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center gap-3">
                                            <label class="label cursor-pointer gap-2">
                                                <input type="radio" 
                                                       name="correct_option" 
                                                       value="{{ $i }}"
                                                       class="radio radio-primary" 
                                                       {{ old('correct_option') == $i ? 'checked' : '' }} />
                                                <span class="label-text">Correct</span>
                                            </label>
                                            
                                            <button type="button" 
                                                    class="btn btn-ghost btn-sm text-error hover:bg-error/10"
                                                    onclick="removeOption(this)">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function addOption() {
        const container = document.getElementById('options-container');
        const index = container.children.length;
        
        const template = `
            <div class="option-item">
                <div class="flex items-start gap-4">
                    <div class="flex-1">
                        <div class="form-control">
                            <input type="text" 
                                   name="options[${index}][text]" 
                                   class="input input-bordered" 
                                   placeholder="Enter option ${index + 1}" />
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <label class="label cursor-pointer gap-2">
                            <input type="radio" 
                                   name="correct_option" 
                                   value="${index}"
                                   class="radio radio-primary" />
                            <span class="label-text">Correct</span>
                        </label>
                        
                        <button type="button" 
                                class="btn btn-ghost btn-sm text-error hover:bg-error/10"
                                onclick="removeOption(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', template);
    }

    function removeOption(button) {
        if (document.querySelectorAll('.option-item').length > 2) {
            button.closest('.option-item').remove();
        } else {
            alert('A question must have at least 2 options.');
        }
    }
</script>
@endpush
@endsection