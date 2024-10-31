@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto bg-gray-50 dark:bg-gray-800 shadow-lg rounded-lg p-8 mt-10">
        <h1 class="text-3xl font-bold text-gray-700 dark:text-gray-100 mb-6 border-b-2 border-gray-200 dark:border-gray-700 pb-4">
            Edit Question
        </h1>

        <form action="{{ route('questions.update', [$quiz, $question]) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Question Form Partial --}}
            @include('quiz.questions._form')

            <div class="flex justify-end mt-8">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-8 rounded-full transition duration-200 ease-in-out shadow-md hover:shadow-lg">
                    Update Question
                </button>
            </div>
        </form>
    </div>
@endsection
