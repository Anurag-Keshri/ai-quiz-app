@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto p-4">
        <h1 class="text-xl mb-4">Add New Question</h1>

        <form action="{{ route('questions.store', $quiz) }}" method="POST">
            @csrf
            @include('questions._form')

            <div class="mt-6">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Create Question
                </button>
            </div>
        </form>
    </div>
@endsection