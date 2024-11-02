@extends('layouts.app', ['navTitle' => 'Create Quiz'])

@section('content')
<div class="min-h-screen">
    <div class="container mx-auto p-4">
        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto mb-8">
            <h1 class="text-4xl font-bold mb-4">Create a New Quiz</h1>
            <p class="text-base-content/70">
                Generate an AI-powered quiz by providing a topic and configuring your preferences below.
            </p>
        </div>

        <div class="max-w-4xl mx-auto">
            <form action="{{ route('quizzes.store') }}" method="POST" class="space-y-6">
                @csrf

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
                                   value="{{ old('title') }}"
                                   placeholder="Enter a descriptive title for your quiz"
                            />
                            @error('title')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Description</span>
                                <span class="label-text-alt text-error">Required</span>
                            </label>
                            <textarea name="description" 
                                      class="textarea textarea-bordered h-24 @error('description') textarea-error @enderror"
                                      placeholder="Provide a brief description of what this quiz is about"
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Quiz Configuration Card -->
                <div class="card bg-base-100 shadow-xl border border-base-300">
                    <div class="card-body">
                        <div class="flex items-center gap-2 mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                            <h2 class="card-title text-2xl">Quiz Configuration</h2>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Number of Questions -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Number of Questions</span>
                                </label>
								<input type="number" 
										name="number_of_questions" 
										id="number_of_questions"
										class="input input-bordered join-item w-full  @error('questions') input-error @enderror"
										value="{{ old('questions', 5) }}"
										min="1"
										max="20"
								/>
                                @error('questions')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <!-- Options per Question -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Options per Question</span>
                                </label>
                                    <input type="number" 
                                           name="number_of_options" 
                                           id="number_of_options"
                                           class="input input-bordered join-item w-full @error('options') input-error @enderror"
                                           value="{{ old('options', 4) }}"
                                           min="2"
                                           max="6"
                                    />
                                @error('options')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <!-- Difficulty Level -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Difficulty Level</span>
                                </label>
                                <select name="difficulty" class="select select-bordered w-full @error('difficulty') select-error @enderror">
                                    <option value="easy" {{ old('difficulty') == 'easy' ? 'selected' : '' }}>Easy</option>
                                    <option value="medium" {{ old('difficulty') == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="hard" {{ old('difficulty') == 'hard' ? 'selected' : '' }}>Hard</option>
                                </select>
                                @error('difficulty')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <!-- Depth Level -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Knowledge Depth</span>
                                </label>
                                <select name="depth" class="select select-bordered w-full @error('depth') select-error @enderror">
                                    <option value="basic" {{ old('depth') == 'basic' ? 'selected' : '' }}>Basic Understanding</option>
                                    <option value="intermediate" {{ old('depth') == 'intermediate' ? 'selected' : '' }}>Intermediate Knowledge</option>
                                    <option value="advanced" {{ old('depth') == 'advanced' ? 'selected' : '' }}>Advanced Concepts</option>
                                </select>
                                @error('depth')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Topic Card -->
                <div class="card bg-base-100 shadow-xl border border-base-300">
                    <div class="card-body">
                        <div class="flex items-center gap-2 mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h2 class="card-title text-2xl">Quiz Topic</h2>
                        </div>
                        
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Topic or Subject Matter</span>
                                <span class="label-text-alt text-error">Required</span>
                            </label>
                            <textarea name="topic" 
                                      class="textarea textarea-bordered h-32 @error('topic') textarea-error @enderror"
                                      placeholder="Describe the topic or subject matter for your quiz. Be as specific as possible. For example: 'The history of Ancient Egypt, focusing on the Old Kingdom period, pyramids, and pharaohs.'">{{ old('topic') }}</textarea>
                            @error('topic')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                            <label class="label">
                                <span class="label-text-alt">The more specific and detailed your topic description, the better the generated questions will be.</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="card bg-base-100 shadow-xl border border-base-300">
                    <div class="card-body">
                        <div class="flex flex-col gap-4">
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Generate Quiz
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection