@extends('layouts.app', ['navTitle' => 'My Quizzes'])

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if($quizzes->isEmpty())
                    <div class="p-6 text-gray-500 text-center">
                        {{ __('You haven\'t created any quizzes yet.') }}
                    </div>
                @else
                    <div class="divide-y divide-gray-200">
                        @foreach($quizzes as $quiz)
                            <div class="p-6 flex items-center justify-between">
                                <div class="flex-1">
                                    <h3 class="text-lg font-medium text-gray-900">
                                        <a href="{{ route('quizzes.show', $quiz) }}" class="hover:text-indigo-600">
                                            {{ $quiz->title }}
                                        </a>
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        {{ Str::limit($quiz->description, 100) }}
                                    </p>
                                    <div class="mt-2 flex items-center text-sm text-gray-500">
                                        <span>{{ $quiz->questions_count ?? 0 }} questions</span>
                                        <span class="mx-2">•</span>
                                        <span>Created {{ $quiz->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('quizzes.edit', $quiz) }}" 
                                       class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                        {{ __('Edit') }}
                                    </a>
                                    
                                    <form action="{{ route('quizzes.destroy', $quiz) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Are you sure you want to delete this quiz?')"
                                                class="inline-flex items-center px-3 py-2 border border-red-300 rounded-md text-sm font-medium text-red-700 bg-white hover:bg-red-50">
                                            {{ __('Delete') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="px-6 py-4">
                        {{ $quizzes->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
