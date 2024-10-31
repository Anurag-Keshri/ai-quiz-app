@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mt-10 mx-auto p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-6">Add New Question</h1>

        <form action="{{ route('questions.store', $quiz) }}" method="POST" class="space-y-6">
            @csrf
            <!-- Include the question form partial -->
            @include('quiz.questions._form')

            <div class="flex justify-end mt-8">
                <button 
                    type="submit" 
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg shadow transition duration-200 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    Create Question
                </button>
            </div>
        </form>
    </div>
@endsection
