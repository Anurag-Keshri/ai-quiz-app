@extends('layouts.app')


@section('content')

<form action="{{ route('quiz.submit', ['id' => $quiz->id]) }}" method="POST" class="flex flex-col gap-4 max-w-2xl mx-auto p-6">
	@csrf
		<h1 class="self-center w-full text-2xl font-bold text-center text-gray-900 dark:text-gray-100 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600">
			Taking Quiz: {{ $quiz->title }}
		</h1>

        @foreach ($quiz->questions as $question)
            <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $loop->iteration }}. {{ $question->question_text }}</h3>
                <ul class="">
                    @foreach (json_decode($question->options) as $option) <!-- Decode JSON options -->
                        <li>
                            <label class="flex items-center">
                                <input type="radio" name="question_{{ $question->id }}" value="{{ $option }}" class="mr-2" required>
                                <span class="text-gray-700 dark:text-gray-300">{{ $option }}</span>
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach

        <x-primary-button type="submit" class="w-full h-12 mt-4">
            Submit Quiz
        </x-primary-button>
    </form>
@endsection
