@extends('layouts.app')

@section('content')
    <div class="py-12 text-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold mb-4">
                        {{ isset($quiz) ? "Attempts for {$quiz->title}" : 'Your Attempts' }}
                    </h2>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2">Date</th>
                                    @if(!isset($quiz))
                                        <th class="px-4 py-2">Quiz</th>
                                    @endif
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Score</th>
                                    <th class="px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attempts as $attempt)
                                    <tr>
                                        <td class="border px-4 py-2">
                                            {{ $attempt->created_at->format('M d, Y H:i') }}
                                        </td>
                                        @if(!isset($quiz))
                                            <td class="border px-4 py-2">
                                                {{ $attempt->quiz->title }}
                                            </td>
                                        @endif
                                        <td class="border px-4 py-2">
                                            {{ $attempt->completed_at ? 'Completed' : 'In Progress' }}
                                        </td>
                                        <td class="border px-4 py-2">
                                            {{ $attempt->completed_at ? $attempt->score : '-' }}
                                        </td>
                                        <td class="border px-4 py-2">
                                            <a href="{{ route('attempts.show', ['quiz' => $attempt->quiz, 'attempt' => $attempt]) }}" 
                                               class="text-blue-600 hover:text-blue-800">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
