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
                        @forelse ($createdQuizzes->reverse() as $quiz)
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
                                    <div class="flex items-center gap-4">
                                        <div class="relative group">
											<a href="{{ route('quiz.edit', $quiz->id) }}" class="flex gap-2 items-center justify-center text-gray-900 dark:text-gray-300">
												<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
												<span class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-1 hidden group-hover:flex text-xs text-white bg-gray-800 rounded py-2 px-2 whitespace-nowrap overflow-hidden text-ellipsis">
													Edit Quiz
												</span>
											</a>
										</div>
                                        <!-- Share Quiz Link Button -->
										<div class="relative group">
											<a href="{{ route('quiz.take', $quiz->id) }}" target="_blank" class="flex gap-2 items-center justify-center text-gray-900 dark:text-gray-300">
												<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-share"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><polyline points="16 6 12 2 8 6"/><line x1="12" x2="12" y1="2" y2="15"/></svg>
												<span class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-1 hidden group-hover:flex text-xs text-white bg-gray-800 rounded py-2 px-2 whitespace-nowrap overflow-hidden text-ellipsis">
													Take Quiz
												</span>
											</a>
										</div>
										<!-- View Responses Link Button -->
										<div class="relative group">
											<a href="{{ route('quiz.responses', $quiz->id) }}" class="flex gap-2 items-center justify-center text-gray-900 dark:text-gray-300">
												<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-big"><path d="M21.801 10A10 10 0 1 1 17 3.335"/><path d="m9 11 3 3L22 4"/></svg>
												<span class="absolute left-1/5 transform -translate-x-1/2 bottom-full mb-1 hidden group-hover:flex text-xs text-white bg-gray-800 rounded py-2 px-2 whitespace-nowrap overflow-hidden text-ellipsis">
													View Responses
												</span>
											</a>
										</div>
                                    </div>
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
                        @forelse ($takenQuizzes->reverse() as $attempt)
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
									<div class="relative group">
										<a href="{{ route('quiz.result', $attempt->id) }}" class="flex gap-2 items-center justify-center text-gray-900 dark:text-gray-300">
											<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
											<span class="absolute left-1/5 transform -translate-x-1/2 bottom-full mb-1 hidden group-hover:flex text-xs text-white bg-gray-800 rounded py-2 px-2 whitespace-nowrap overflow-hidden text-ellipsis">
												View Result
											</span>
										</a>
									</div>
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
