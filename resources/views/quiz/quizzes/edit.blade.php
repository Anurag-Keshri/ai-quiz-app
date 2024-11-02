@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-base-200 py-8">
    <div class="container mx-auto px-4">

        <div class="max-w-4xl mx-auto">
            <form action="{{ route('quizzes.update', $quiz) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Basic Information Card -->
                <div class="card bg-base-100 shadow-xl border border-base-300">
                    <div class="card-body">
                        <div class="flex items-center gap-2 mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <h2 class="card-title text-2xl">Basic Information</h2>
                        </div>
                        
                        <!-- Title -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Quiz Title</span>
                                <span class="label-text-alt text-error">Required</span>
                            </label>
                            <input type="text" 
                                   name="title" 
                                   class="input input-bordered @error('title') input-error @enderror" 
                                   value="{{ old('title', $quiz->title) }}"
                                   placeholder="Enter a descriptive title" />
                            @error('title')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="form-control mt-4">
                            <label class="label">
                                <span class="label-text font-medium">Description</span>
                                <span class="label-text-alt text-error">Required</span>
                            </label>
                            <textarea name="description" 
                                      class="textarea textarea-bordered h-32 @error('description') textarea-error @enderror"
                                      placeholder="Provide a clear description of your quiz">{{ old('description', $quiz->description) }}</textarea>
                            @error('description')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Questions Card -->
                <div class="card bg-base-100 shadow-xl border border-base-300">
                    <div class="card-body">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h2 class="card-title text-2xl">Questions</h2>
                            </div>
                            <button type="button" onclick="addQuestion()" class="btn btn-primary btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Add Question
                            </button>
                        </div>

                        <div id="questions-container" class="space-y-6">
                            @foreach($quiz->questions as $index => $question)
                                <div class="card bg-base-200 shadow-sm question-card">
                                    <div class="card-body">
                                        <div class="flex justify-between items-center mb-4">
                                            <div class="badge badge-primary">Question {{ $index + 1 }}</div>
                                            <button type="button" onclick="removeQuestion(this)" class="btn btn-ghost btn-sm text-error">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>

                                        <input type="hidden" name="questions[{{ $index }}][id]" value="{{ $question->id }}">
                                        <div class="form-control">
                                            <input type="text" 
                                                   name="questions[{{ $index }}][question_text]" 
                                                   class="input input-bordered" 
                                                   value="{{ $question->question_text }}"
                                                   placeholder="Enter your question" />
                                        </div>

                                        <div class="divider">Options</div>

                                        <div class="space-y-3">
                                            @foreach($question->options as $optionIndex => $option)
                                                <div class="flex items-center gap-4">
                                                    <input type="hidden" 
                                                           name="questions[{{ $index }}][options][{{ $optionIndex }}][id]" 
                                                           value="{{ $option->id }}">
                                                    
                                                    <div class="form-control flex-1">
                                                        <input type="text" 
                                                               name="questions[{{ $index }}][options][{{ $optionIndex }}][option_text]" 
                                                               class="input input-bordered input-sm" 
                                                               value="{{ $option->option_text }}"
                                                               placeholder="Option text" />
                                                    </div>

                                                    <label class="label cursor-pointer gap-2">
                                                        <span class="label-text">Correct</span>
                                                        <input type="radio" 
                                                               name="questions[{{ $index }}][correct_option]" 
                                                               value="{{ $optionIndex }}"
                                                               {{ $option->is_correct ? 'checked' : '' }}
                                                               class="radio radio-primary radio-sm" />
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="mt-4">
                                            <button type="button" onclick="addOption(this)" class="btn btn-ghost btn-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                                </svg>
                                                Add Option
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Settings Card -->
                <div class="card bg-base-100 shadow-xl border border-base-300">
                    <div class="card-body">
                        <div class="flex items-center gap-2 mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <h2 class="card-title text-2xl">Settings</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Difficulty -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Difficulty Level</span>
                                </label>
                                <select name="difficulty" class="select select-bordered w-full">
                                    @foreach(['easy', 'medium', 'hard'] as $difficulty)
                                        <option value="{{ $difficulty }}" 
                                                {{ old('difficulty', $quiz->difficulty) === $difficulty ? 'selected' : '' }}>
                                            {{ ucfirst($difficulty) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Time Limit -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Time Limit (minutes)</span>
                                </label>
                                <input type="number" 
                                       name="time_limit" 
                                       class="input input-bordered" 
                                       value="{{ old('time_limit', $quiz->time_limit) }}"
                                       min="1" 
                                       max="180" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-4">
                    <a href="{{ route('quizzes.show', $quiz) }}" class="btn btn-ghost">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        Save Changes
                    </button>
                </div>

                <!-- Danger Zone -->
                <div class="card bg-base-100 shadow-xl border border-error/20 mt-8">
                    <div class="card-body">
                        <h3 class="card-title text-xl text-error">Danger Zone</h3>
                        <p class="text-sm text-base-content/70">
                            Once you delete a quiz, there is no going back. Please be certain.
                        </p>
                        <div class="card-actions justify-end mt-4">
                            <form action="{{ route('quizzes.destroy', $quiz) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-error" 
                                        onclick="return confirm('Are you sure you want to delete this quiz?')">
                                    Delete Quiz
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Add your JavaScript for handling questions and options here
// (Same as before)
</script>
@endpush
@endsection