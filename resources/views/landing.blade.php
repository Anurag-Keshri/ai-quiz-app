@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center p-4">
        <div class="w-full max-w-md dark:bg-gray-800 dark:border-gray-700 rounded-lg p-4 mt-36">
			<div class="text-center text-2xl font-bold text-neutral-50">Ai Quiz App</div>

            <p class="text-center text-neutral-500">Create, take, or view your quizzes</p>

            <div class="flex flex-col gap-4 mt-6">
                <a href="/quiz/create">
                    <x-primary-button class="w-full h-10">
                        Create Quiz
                    </x-primary-button>
                </a>

                <form id="takeQuizForm" method="GET" class="space-y-2" onsubmit="updateFormAction()">
                    <x-input-label for="quiz_id" :value="__('Quiz ID')" />
                    <div class="flex space-x-2">
                        <x-text-input
                            id="quiz_id"
                            type="number"
                            placeholder="Enter Quiz ID"
                            required
                            class="flex-grow"
                        />
                        <x-primary-button type="submit">
                            Take Quiz
                        </x-primary-button>
                    </div>
                </form>

                <a href="/quiz/my-quizzes">
                    <x-secondary-button class="w-full h-10">
                        My Quizzes
                    </x-secondary-button>
                </a>
            </div>
        </div>
    </div>

    <script>
        function updateFormAction() {
            const quizId = document.getElementById('quiz_id').value;
            const form = document.getElementById('takeQuizForm');
            if (quizId) {
                form.action = `/quiz/${quizId}/take`;
            }
        }
    </script>
@endsection
