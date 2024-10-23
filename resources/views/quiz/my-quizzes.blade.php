@extends('layouts.app', ['navTitle' => 'My Quizzes'])

@section('header')
    <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-gray-100">My Quizzes</h1>
@endsection

@section('content')
    <div class="container mx-auto p-4 space-y-6 mt-8">
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Created Quizzes Section -->
            <section>
                <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-gray-100">Quizzes I Created</h2>
                <div class="overflow-y-auto h-[calc(100vh-200px)] border rounded-lg bg-white dark:bg-gray-800 p-4 shadow-md">
                    <div class="space-y-3">
                        @forelse ($createdQuizzes as $quiz)
                            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-3 shadow-sm hover:shadow-md transition-shadow duration-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-medium text-gray-900 dark:text-gray-100">
                                            <a href="{{ route('quiz.edit', $quiz->id) }}" class="hover:text-blue-500 transition-colors duration-200">{{ $quiz->title }}</a>
                                        </h3>
                                        <div class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-days"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>
											{{ $quiz->created_at->format('F j, Y h:i A') }} • Questions: {{ $quiz->number_of_questions }}
                                        </div>
                                    </div>
                                    <a href="{{ route('quiz.edit', $quiz->id) }}" class="flex gap-2 items-center justify-center text-gray-900 dark:text-gray-300">
										<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
										Edit
									</a>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg text-center text-gray-600 dark:text-gray-400">
                                No quizzes created yet.
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            <!-- Taken Quizzes Section -->
            <section>
                <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-gray-100">Quizzes I Have Taken</h2>
                <div class="overflow-y-auto h-[calc(100vh-200px)] border rounded-lg bg-white dark:bg-gray-800 p-4 shadow-md">
                    <div class="space-y-3">
                        @forelse ($takenQuizzes as $attempt)
                            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-3 shadow-sm hover:shadow-md transition-shadow duration-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-medium text-gray-900 dark:text-gray-100">
                                            <a href="{{ route('quiz.result', $attempt->id) }}" class="hover:text-blue-500 transition-colors duration-200">{{ $attempt->quiz->title }}</a>
                                        </h3>
                                        <div class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-days"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>
                                            {{ $attempt->created_at->format('F j, Y h:i A') }} • Score: {{ $attempt->score }}
                                        </div>
                                    </div>
                                    <a href="{{ route('quiz.result', $attempt->id) }}" class="flex gap-2 items-center justify-center text-gray-900 dark:text-gray-300">
										<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
										Results
									</a>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg text-center text-gray-600 dark:text-gray-400">
                                No quizzes taken yet.
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
