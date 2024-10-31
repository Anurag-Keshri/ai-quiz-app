@extends('layouts.app')

@section('content')
    <div class="py-12 text-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold mb-4">Start Quiz: {{ $quiz->title }}</h2>
                    
                    <div class="mb-6">
                        <h3 class="font-semibold mb-2">Quiz Rules:</h3>
                        <ul class="list-disc list-inside space-y-2">
                            <li>You will have {{ $quiz->rules->time_limit ?? 'unlimited' }} minutes to complete this quiz</li>
                            <li>There are {{ $quiz->questions->count() }} questions in total</li>
                            @if($quiz->rules->minimum_score)
                                <li>Minimum score required to pass: {{ $quiz->rules->minimum_score }}%</li>
                            @endif
                        </ul>
                    </div>

                    <form method="POST" action="{{ route('attempts.store', $quiz) }}">
                        @csrf
                        <button type="submit" 
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Start Quiz
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection