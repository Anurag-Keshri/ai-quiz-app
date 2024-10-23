<h1>Taking Quiz: {{ $quiz->title }}</h1>

<form action="{{ route('quiz.submit', ['id' => $quiz->id]) }}" method="POST">
    @csrf

    @foreach ($quiz->questions as $question)
        <div>
            <h3>Question {{ $loop->iteration }}: {{ $question->question_text }}</h3>
            <ul>
                @foreach (json_decode($question->options) as $option) <!-- Decode JSON options -->
                    <li>
                        <label>
                            <input type="radio" name="question_{{ $question->id }}" value="{{ $option }}">
                            {{ $option }}
                        </label>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach

    <button type="submit">Submit Quiz</button>
</form>
