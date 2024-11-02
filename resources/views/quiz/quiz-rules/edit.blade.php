@extends('layouts.app')

@section('content')
<div class="min-h-[calc(100vh-73px)] bg-base-200 py-4">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto space-y-6">
            <form method="POST" action="{{ route('quiz_rules.update', $quiz) }}" class="flex flex-col gap-4">
                @csrf
                @method('PUT')
                
                <!-- Header Section with Buttons -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                    <h1 class="text-2xl font-bold">Edit Quiz Rules</h1>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('quiz_rules.show', $quizRules) }}" 
                           class="btn btn-ghost btn-sm normal-case">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="btn btn-primary btn-sm normal-case px-6">
                            Save Changes
                        </button>
                    </div>
                </div>

                <!-- Time & Date Availability Card -->
                <div class="card bg-base-100 shadow-xl border border-base-300">
                    <div class="card-body p-6">
                        <h2 class="card-title text-lg mb-2">Time & Availability</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <!-- Time Limit -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Time Limit</span>
                                </label>
                                <div class="join">
                                    <input type="number" 
                                           name="time_limit" 
                                           class="input input-bordered w-full join-item @error('time_limit') input-error @enderror" 
                                           value="{{ old('time_limit', $quizRules->time_limit) }}"
                                           placeholder="Enter time" />
                                    <span class="btn join-item no-animation pointer-events-none">minutes</span>
                                </div>
                                @error('time_limit')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <!-- Start Date -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Start Date</span>
                                </label>
                                <input type="datetime-local" 
                                       name="start_date" 
                                       class="input input-bordered w-full @error('start_date') input-error @enderror" 
                                       value="{{ old('start_date', $quizRules->start_date) }}" />
                                @error('start_date')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <!-- End Date -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">End Date</span>
                                </label>
                                <input type="datetime-local" 
                                       name="end_date" 
                                       class="input input-bordered w-full @error('end_date') input-error @enderror" 
                                       value="{{ old('end_date', $quizRules->end_date) }}" />
                                @error('end_date')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quiz Settings Card -->
                <div class="card bg-base-100 shadow-xl border border-base-300">
                    <div class="card-body p-6">
                        <h2 class="card-title text-lg mb-6">Quiz Settings</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach([
                                'show_score' => ['Show Score', 'Show score after submission', 'Users can see their final score immediately after completing the quiz'],
                                'shuffle_options' => ['Shuffle Options', 'Randomize answer order', 'Answer options are presented in a random order for each attempt'],
                                'shuffle_questions' => ['Shuffle Questions', 'Randomize question order', 'Questions appear in a different order for each attempt'],
                                'show_correct_answer' => ['Show Answers', 'Show correct answers', 'Display correct answers after quiz completion']
                            ] as $key => $details)
                                <div class="card bg-base-200">
                                    <div class="card-body p-6">
                                        <label class="cursorspace-y-2">
                                            <div class="flex items-center justify-between gap-4">
                                                <div>
                                                    <h3 class="font-medium">{{ $details[0] }}</h3>
                                                    <p class="text-sm text-base-content/70 mt-1">{{ $details[1] }}</p>
                                                </div>
                                                <input type="checkbox"
                                                       name="{{ $key }}"
                                                       class="toggle toggle-success"
                                                       value="1"
                                                       {{ old($key, $quizRules->$key) ? 'checked' : '' }} />
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection