<h1>My Quizzes</h1>

<div style="display: flex; justify-content: space-between;">
    <!-- Created Quizzes Column -->
    <div style="width: 45%;">
        <h2>Quizzes I Created</h2>
        <ul>
            @forelse ($createdQuizzes as $quiz)
                <li>
                    <a href="{{ route('quiz.edit', $quiz->id) }}">{{ $quiz->title }}</a>
                </li>
            @empty
                <li>No quizzes created yet.</li>
            @endforelse
        </ul>
    </div>

    <!-- Taken Quizzes Column -->
    <div style="width: 45%;">
        <h2>Quizzes I Have Taken</h2>
        <ul>
            @forelse ($takenQuizzes as $attempt)
                <li>
                    <a href="{{ route('quiz.result', $attempt->id) }}">{{ $attempt->quiz->title }}</a>
                </li>
            @empty
                <li>No quizzes taken yet.</li>
            @endforelse
        </ul>
    </div>
</div>
