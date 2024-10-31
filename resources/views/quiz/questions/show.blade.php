@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto p-4">
        <div class="mb-6">
            <h1 class="text-xl mb-2">{{ $question->question_text }}</h1>
            @if($question->time_limit)
                <p class="text-gray-600">Time limit: {{ $question->time_limit }} seconds</p>
            @endif
        </div>

        <div class="space-y-3">
            <h2 class="font-medium">Options:</h2>
            @foreach($question->options as $option)
                <div class="flex items-center space-x-2 p-2 rounded {{ $option->is_correct ? 'bg-green-100' : 'bg-gray-50' }}">
                    <span class="w-6">{{ $loop->iteration }}.</span>
                    <span>{{ $option->option_text }}</span>
                    @if($option->is_correct)
                        <span class="text-green-600 ml-2">(Correct Answer)</span>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mt-6 flex space-x-4">
            <a href="{{ route('questions.edit', [$quiz, $question]) }}" 
               class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Edit Question
            </a>
            <form action="{{ route('questions.destroy', [$quiz, $question]) }}" 
                  method="POST" 
                  class="inline"
                  onsubmit="return confirm('Are you sure you want to delete this question?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    Delete Question
                </button>
            </form>
        </div>

        <div class="mt-6">
            <a href="{{ route('landing') }}" 
               class="text-blue-500 hover:underline">
                ← Back to Home
            </a>
        </div>
    </div>
@endsection