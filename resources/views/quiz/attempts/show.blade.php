@extends('layouts.app')

@section('content')
<div class="min-h-[calc(100vh-73px)] bg-base-200 p-2 sm:p-4"> 
    <div class="container mx-auto px-2 sm:px-4"> 
        <div class="max-w-4xl mx-auto space-y-4 sm:space-y-6"> 
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-4">
                <div class="w-full sm:w-auto"> {{-- Added width control --}}
                    <h1 class="text-xl sm:text-2xl font-bold break-words">{{ $quiz->title }}</h1>
                    <p class="text-sm sm:text-base text-base-content/70">
                        Started: {{ $attempt->created_at->format('M d, Y h:i A') }}
                    </p>
                </div>

                @if(!$attempt->completed_at)
                    <!-- Timer for Active Quiz -->
                    <div class="flex items-center gap-2 text-base sm:text-lg font-mono"> {{-- Adjusted font size --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span id="timer" class="font-bold">00:00</span>
                    </div>
                @else
                    <!-- Completed Status -->
                    <div class="badge badge-success gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Completed
                    </div>
                @endif
            </div>

            @if(!$attempt->completed_at)
                <!-- Active Quiz Form -->
                <form method="POST" action="{{ route('attempts.submit', ['quiz' => $quiz, 'attempt' => $attempt]) }}" class="space-y-4 sm:space-y-6">
                    @csrf
                    
                    @foreach($quiz->questions as $question)
                        <div class="card bg-base-100 shadow-xl border border-base-300">
                            <div class="card-body p-3 sm:p-6"> {{-- Adjusted padding for mobile --}}
                                <div class="flex items-start gap-2 sm:gap-3">
                                    <div class="badge badge-primary shrink-0">{{ $loop->iteration }}</div>
                                    <div class="flex-1 min-w-0"> {{-- Added min-width to prevent overflow --}}
                                        <h3 class="font-medium text-base sm:text-lg mb-3 sm:mb-4 break-words">{{ $question->question_text }}</h3>
                                        
                                        <div class="space-y-2 sm:space-y-3">
                                            @foreach($question->options as $option)
                                                <label class="flex items-center gap-2 sm:gap-3 p-2 sm:p-3 rounded-lg hover:bg-base-200 cursor-pointer transition-colors">
                                                    <input type="radio" 
                                                           name="answers[{{ $question->id }}]" 
                                                           value="{{ $option->id }}"
                                                           class="radio radio-primary radio-sm sm:radio-md" 
                                                           {{ old("answers.{$question->id}") == $option->id ? 'checked' : '' }}>
                                                    <span class="flex-1 text-sm sm:text-base break-words">{{ $option->option_text }}</span>
                                                </label>
                                            @endforeach
                                        </div>

                                        @error("answers.{$question->id}")
                                            <div class="mt-2 text-xs sm:text-sm text-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" 
                                class="btn btn-primary btn-sm sm:btn-md w-full sm:w-auto" {{-- Made button full width on mobile --}}
                                onclick="return confirm('Are you sure you want to submit this quiz? You won\'t be able to change your answers after submission.')">
                            Submit Quiz
                        </button>
                    </div>
                </form>

            @else
                <!-- Completed Quiz View -->
                <div class="space-y-4 sm:space-y-6">
                    @if($quiz->rules->show_score)
                        <div class="card bg-base-100 shadow-xl border border-base-300">
                            <div class="card-body p-3 sm:p-6">
                                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
                                    <div>
                                        <h2 class="card-title text-lg sm:text-xl">Your Score</h2>
                                        <p class="text-sm sm:text-base text-base-content/70">Completed on {{ $attempt->completed_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                    <div class="text-2xl sm:text-3xl font-bold text-primary">
                                        {{ $attempt->score }}%
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @foreach($attempt->answers as $answer)
                        <div class="card bg-base-100 shadow-xl border border-base-300">
                            <div class="card-body p-3 sm:p-6">
                                <div class="flex items-start gap-2 sm:gap-3">
                                    <div class="badge badge-primary shrink-0">{{ $loop->iteration }}</div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-medium text-base sm:text-lg mb-3 sm:mb-4 break-words">{{ $answer->option->question->question_text }}</h3>
                                        
                                        <div class="space-y-2 sm:space-y-3">
                                            @foreach($answer->option->question->options as $option)
                                                <div class="grid grid-cols-1  md:grid-cols-[auto,1fr,auto] items-center gap-2 sm:gap-3 p-2 sm:p-3 rounded-lg {{ (($option->id === $answer->option_id) ? ($option->is_correct) ? 'bg-success/10 border border-success/20' : 'bg-error/10 border border-error/20' : '') }}">
													<div class="flex justify-between gap-2">
														@if($quiz->rules->show_correct_answer)
															@if($option->is_correct)
																<div class="badge badge-success gap-1 sm:gap-2 w-20 sm:w-24 text-xs sm:text-sm">
																	<svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4" viewBox="0 0 20 20" fill="currentColor">
																		<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
																	</svg>
																	Correct
																</div>
															@else
																<div class="badge badge-ghost gap-1 sm:gap-2 w-20 sm:w-24 text-xs sm:text-sm">
																	<svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4" viewBox="0 0 20 20" fill="currentColor">
																		<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
																	</svg>
																	Incorrect
																</div>
															@endif
														@endif

														@if($option->id === $answer->option_id)
															<div class="badge badge-ghost md:hidden text-xs sm:text-sm md:justify-self-end">Your answer</div>
														@endif
													</div>
                                                    
                                                    <span class="{{ $option->id === $answer->option_id ? 'font-medium' : '' }} text-sm sm:text-base break-words">
                                                        {{ $option->option_text }}
                                                    </span>

                                                    @if($option->id === $answer->option_id)
                                                        <div class="badge badge-ghost text-xs hidden md:flex sm:text-sm md:justify-self-end">Your answer</div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Timer script remains unchanged --}}
@if(!$attempt->completed_at && $quiz->rules->time_limit)
    @push('scripts')
    <script>
        // Timer implementation remains the same
    </script>
    @endpush
@endif
@endsection