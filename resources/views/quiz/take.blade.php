@extends('layouts.app', ['navTitle' => 'Take Quiz'])

@section('content')
    @php
        // Get the time limit in seconds if it exists
        $timeLimit = $quiz->time_limit; // Assuming time_limit is in minutes
        $timeLimitInSeconds = $timeLimit ? $timeLimit * 60 : 0; // Convert to seconds

        // Get the started_at timestamp from the attempt
        $startedAt = $quizAttempt->started_at; // Assuming $quizAttempt is passed to the view
        $startedAtTimestamp = $startedAt->timestamp; // Get the timestamp

        // Calculate elapsed time in seconds
        $currentTimestamp = now()->timestamp; // Current timestamp when the quiz is opened
        $elapsedTime = $currentTimestamp - $startedAtTimestamp;

        // Calculate remaining time
        $remainingTime = max($timeLimitInSeconds - $elapsedTime, 0); // Ensure remaining time is not negative
    @endphp

    <form id="quiz-form" action="{{ route('quiz.submit', ['id' => $quiz->id, 'attemptId' => $attemptId]) }}" method="POST" class="flex flex-col gap-6 max-w-3xl mx-auto p-6">
        @csrf
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
            <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-gray-100 mb-4">
                Taking Quiz: {{ $quiz->title }}
            </h1>

            @if ($remainingTime > 0)
                <div id="timer" class="text-center">
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-1">Time Remaining</p>
                    <div id="time-remaining" class="text-3xl font-bold text-indigo-600 dark:text-indigo-400"></div>
                </div>
            @endif
        </div>

        @php
            if ($quiz->shuffle_questions) {
                $questions = $quiz->questions->shuffle();
            } else {
                $questions = $quiz->questions;
            }
        @endphp

        @foreach ($questions as $question)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $loop->iteration }}. {{ $question->question_text }}</h3>
                <ul class="mt-2 space-y-2">
                    @php
                        if ($quiz->shuffle_options) {
                            $options = collect(json_decode($question->options))->shuffle();
                        } else {
                            $options = json_decode($question->options);
                        }
                    @endphp
                    @foreach ($options as $option) <!-- Decode JSON options -->
                        <li>
                            <label class="flex items-center p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-150">
                                <input type="radio" name="question_{{ $question->id }}" value="{{ $option }}" class="mr-2" required>
                                <span class="text-gray-700 dark:text-gray-300">{{ $option }}</span>
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach

        <x-primary-button type="submit" class="w-full h-12 mt-4">
            Submit Quiz
        </x-primary-button>
    </form>

    @if ($remainingTime > 0)
        <script>
            let timeRemaining = {{ $remainingTime }};
            const timerElement = document.getElementById('time-remaining');

            function formatTime(seconds) {
                const hours = Math.floor(seconds / 3600);
                const minutes = Math.floor((seconds % 3600) / 60);
                const remainingSeconds = seconds % 60;
                
                return [
                    hours.toString().padStart(2, '0'),
                    minutes.toString().padStart(2, '0'),
                    remainingSeconds.toString().padStart(2, '0')
                ].join(':');
            }

            function updateTimer() {
                if (timeRemaining <= 0) {
                    clearInterval(countdown);
                    document.getElementById('quiz-form').submit();
                } else {
                    timerElement.textContent = formatTime(timeRemaining);
                    timeRemaining--;
                }
            }

            updateTimer(); // Initial call to set the timer immediately
            const countdown = setInterval(updateTimer, 1000);
        </script>
    @endif
@endsection
