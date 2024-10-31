@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
    <div class="space-y-6">
        <!-- Question Header -->
        <div class="bg-white dark:bg-gray-800/80 rounded-2xl p-6 shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-800">
            <div class="flex items-start justify-between">
                <div class="space-y-1">
                    <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-400">
                            Question {{ $question->order ?? '#' }}
                        </span>
                        @if($question->time_limit)
                            <span class="inline-flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $question->time_limit }} seconds</span>
                            </span>
                        @endif
                    </div>
                    <h1 class="text-xl font-semibold text-gray-900 dark:text-white">
                        {{ $question->question_text }}
                    </h1>
                </div>

                <div class="flex items-center space-x-2">
                    <a href="{{ route('questions.edit', [$quiz, $question]) }}" 
                       class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-500/10 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Answer Options -->
        <div class="bg-white dark:bg-gray-800/80 rounded-2xl p-6 shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-800">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Answer Options</h2>
            <div class="grid gap-3">
                @foreach($question->options as $option)
                    <div class="relative group flex items-center p-4 rounded-xl {{ $option->is_correct 
                        ? 'bg-emerald-50 dark:bg-emerald-500/10 ring-1 ring-emerald-500/10 dark:ring-emerald-500/20' 
                        : 'bg-gray-50 dark:bg-gray-800/50' }}">
                        <div class="flex-shrink-0 mr-4">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $option->is_correct 
                                ? 'bg-emerald-100 dark:bg-emerald-500/20' 
                                : 'bg-gray-100 dark:bg-gray-700' }}">
                                <span class="text-sm font-medium {{ $option->is_correct 
                                    ? 'text-emerald-700 dark:text-emerald-400' 
                                    : 'text-gray-700 dark:text-gray-400' }}">
                                    {{ $loop->iteration }}
                                </span>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium {{ $option->is_correct 
                                ? 'text-emerald-900 dark:text-emerald-300' 
                                : 'text-gray-900 dark:text-gray-300' }}">
                                {{ $option->option_text }}
                            </p>
                        </div>
                        @if($option->is_correct)
                            <div class="ml-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-500/20 dark:text-emerald-400">
                                    Correct Answer
                                </span>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Navigation -->
        <div class="flex items-center justify-between pt-6">
            <a href="{{ route('landing') }}" 
               class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Quiz
            </a>

            <div class="flex items-center space-x-4">
                @if($previousQuestion)
                    <a href="{{ route('questions.show', [$quiz, $previousQuestion]) }}" 
                       class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Previous
                    </a>
                @endif

                @if($nextQuestion)
                    <a href="{{ route('questions.show', [$quiz, $nextQuestion]) }}" 
                       class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-500/10 transition-colors">
                        Next
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                @endif
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
        <div class="max-w-sm w-full bg-white dark:bg-gray-800 shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3 w-0 flex-1 pt-0.5">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Success!</p>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ session('success') }}</p>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex">
                        <button @click="show = false" class="rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <span class="sr-only">Close</span>
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection