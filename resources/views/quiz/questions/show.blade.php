@extends('layouts.app')

@section('content')
<div class="min-h-[calc(100vh-73px)] bg-base-200 py-4">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto space-y-6">
            <!-- Question Header -->
            <div class="card bg-base-100 shadow-xl border border-base-300">
                <div class="card-body">
                    <div class="flex items-center justify-between">
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <div class="badge badge-primary">Question ID: {{ $question->id }}</div>
                            </div>
                            <h1 class="text-xl font-semibold">
                                {{ $question->question_text }}
                            </h1>
                        </div>

                        <div class="flex items-center gap-2 h-full">
                            <a href="{{ route('questions.edit', [$quiz, $question]) }}" 
                               class="btn btn-ghost btn-sm gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit
                            </a>
                            <form action="{{ route('questions.destroy', [$quiz, $question]) }}" 
                                  method="POST" 
                                  class="inline"
                                  x-data
                                  @submit.prevent="if (confirm('Are you sure you want to delete this question? This action cannot be undone.')) $el.submit()">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-ghost btn-sm text-error hover:bg-error/10 gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Answer Options -->
            <div class="card bg-base-100 shadow-xl border border-base-300">
                <div class="card-body">
                    <h2 class="card-title text-lg mb-4">Options</h2>
                    <div class="grid gap-3">
                        @foreach($question->options as $option)
                            <div class="flex items-center p-4 rounded-xl {{ $option->is_correct 
                                ? 'bg-success/10 border border-success/20' 
                                : 'bg-base-200' }}">
                                <div class="flex-shrink-0 mr-4">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $option->is_correct 
                                        ? 'bg-success/20' 
                                        : 'bg-base-100' }}">
                                        <span class="text-sm font-medium {{ $option->is_correct 
                                            ? 'text-success' 
                                            : 'text-base-content' }}">
                                            {{ $loop->iteration }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium {{ $option->is_correct 
                                        ? 'text-success' 
                                        : 'text-base-content' }}">
                                        {{ $option->option_text }}
                                    </p>
                                </div>
                                @if($option->is_correct)
                                    <div class="ml-4">
                                        <div class="badge badge-success gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Correct Answer
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <div class="flex items-center justify-between pt-6">
                <a href="{{ route('landing') }}" 
                   class="btn btn-ghost btn-sm gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Quiz
                </a>

                <div class="flex items-center gap-3">
                    @if($previousQuestion)
                        <a href="{{ route('questions.show', [$quiz, $previousQuestion]) }}" 
                           class="btn btn-ghost btn-sm gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Previous
                        </a>
                    @endif

                    @if($nextQuestion)
                        <a href="{{ route('questions.show', [$quiz, $nextQuestion]) }}" 
                           class="btn btn-primary btn-sm gap-2">
                            Next
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div x-data="{ show: true }"
         x-show="show"
         x-transition:enter="transform ease-out duration-300 transition"
         x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
         x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed bottom-0 right-0 m-6">
        <div class="alert alert-success shadow-lg">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
            <div class="flex-none">
                <button @click="show = false" class="btn btn-ghost btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endif
@endsection