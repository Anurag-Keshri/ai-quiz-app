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
                                            <a href="{{ route('quiz.view', $quiz->id) }}" class="hover:text-blue-500 transition-colors duration-200">{{ $quiz->title }}</a>
                                        </h3>
                                        <div class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-2">
                                            @include('components.icons.calendar-days', ['class' => 'w-4 h-4'])
                                            {{ $quiz->created_at->format('F j, Y h:i A') }} • Questions: {{ $quiz->questions->count() }}
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4">
										<!-- Edit Quiz Link Button -->
										<div class="relative group">
											<a href="{{ route('quiz.edit', $quiz->id) }}" class="flex gap-2 items-center justify-center text-gray-900 dark:text-gray-300">
												@include('components.icons.pencil', ['class' => 'w-4 h-4'])
												<span class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-1 hidden group-hover:flex text-xs text-white bg-gray-800 rounded py-2 px-2 whitespace-nowrap overflow-hidden text-ellipsis">
													Edit Quiz
												</span>
											</a>
										</div>
										<!-- Update Rules Link Button -->
										<div class="relative group">
											<a href="{{ route('quiz.update.rules', $quiz->id) }}" class="flex gap-2 items-center justify-center text-gray-900 dark:text-gray-300">
												@include('components.icons.settings', ['class' => 'w-4 h-4'])
												<span class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-1 hidden group-hover:flex text-xs text-white bg-gray-800 rounded py-2 px-2 whitespace-nowrap overflow-hidden text-ellipsis">
													Update Rules
												</span>
											</a>
										</div>
                                        <!-- Share Quiz Link Button -->
										<div class="relative group">
											<a href="{{ route('quiz.take', $quiz->id) }}" target="_blank" class="flex gap-2 items-center justify-center text-gray-900 dark:text-gray-300">
												@include('components.icons.share', ['class' => 'w-4 h-4'])
												<span class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-1 hidden group-hover:flex text-xs text-white bg-gray-800 rounded py-2 px-2 whitespace-nowrap overflow-hidden text-ellipsis">
													Take Quiz
												</span>
											</a>
										</div>
										<!-- View Responses Link Button -->
										<div class="relative group">
											<a href="{{ route('quiz.responses', $quiz->id) }}" class="flex gap-2 items-center justify-center text-gray-900 dark:text-gray-300">
												@include('components.icons.clipboard-list', ['class' => 'w-4 h-4'])
												<span class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-1 hidden group-hover:flex text-xs text-white bg-gray-800 rounded py-2 px-2 whitespace-nowrap overflow-hidden text-ellipsis">
													View Responses
												</span>
											</a>
										</div>
										<!-- Delete Quiz Link Button -->
										<div class="relative group">
											<form action="{{ route('quiz.destroy', $quiz->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this quiz?');">
												@csrf
												@method('DELETE')
												<button type="submit" class="flex gap-2 items-center justify-center text-gray-900 dark:text-gray-300">
													@include('components.icons.trash', ['class' => 'w-4 h-4'])
													<span class="absolute left-1/5 transform -translate-x-1/2 bottom-full mb-1 hidden group-hover:flex text-xs text-white bg-gray-800 rounded py-2 px-2 whitespace-nowrap overflow-hidden text-ellipsis">
														Delete Quiz
													</span>
												</button>
											</form>
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
                                            @include('components.icons.calendar-days', ['class' => 'w-4 h-4'])
                                            {{ $attempt->created_at->format('F j, Y h:i A') }} @if ($attempt->quiz->rules->show_score) • Score: {{ $attempt->score }} @endif
                                        </div>
                                    </div>
									<div class="relative group">
										<a href="{{ route('quiz.result', $attempt->id) }}" class="flex gap-2 items-center justify-center text-gray-900 dark:text-gray-300">
											@include('components.icons.eye', ['class' => 'w-4 h-4'])
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
