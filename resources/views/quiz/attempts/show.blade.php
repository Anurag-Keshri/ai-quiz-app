@extends('layouts.app')

@section('content')
    <div class="py-12 text-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold">{{ $quiz->title }}</h2>
                        <p class="text-gray-600">
                            Started: {{ $attempt->created_at->format('M d, Y H:i') }}
                        </p>
                    </div>

                    @if(!$attempt->completed_at)
                        {{-- Active Quiz View --}}
                        <form method="POST" action="{{ route('attempts.submit', ['quiz' => $quiz, 'attempt' => $attempt]) }}">
                            @csrf
                            
                            <div class="space-y-6">
                                @foreach($quiz->questions as $question)
                                    <div class="p-4 bg-gray-50 rounded-lg">
                                        <p class="font-semibold mb-2">{{ $loop->iteration }}. {{ $question->question_text }}</p>
                                        
                                        <div class="ml-4 space-y-2">
                                            @foreach($question->options as $option)
                                                <label class="flex items-center">
                                                    <input type="radio" 
                                                           name="answers[{{ $question->id }}]" 
                                                           value="{{ $option->id }}"
                                                           class="mr-2">
                                                    {{ $option->option_text }}
                                                </label>
                                            @endforeach
                                        </div>

                                        @error("answers.{$question->id}")
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-6 flex justify-end">
                                <button type="submit" 
                                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600"
                                        onclick="return confirm('Are you sure you want to submit this quiz? You won\'t be able to change your answers after submission.')">
                                    Submit Quiz
                                </button>
                            </div>
                        </form>
                    @else
                        {{-- Completed Quiz View --}}
                        <div class="space-y-6">
                            @foreach($attempt->answers as $answer)
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <p class="font-semibold mb-2">{{ $loop->iteration }}. {{ $answer->option->question->question_text }}</p>
                                    
                                    <div class="ml-4 space-y-2">
                                        @foreach($answer->option->question->options as $option)
                                            <div class="flex items-center">
                                                <span class="mr-2">
                                                    @if($option->id === $answer->option_id)
                                                        ⚫
                                                    @endif
                                                </span>
                                                <span class="{{ $option->id === $answer->option_id ? 'font-medium' : '' }}">
                                                    {{ $option->option_text }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection 