<h1>{{ $quizAttempt->quiz->title }}</h1>
<h2>Your Score: {{ $quizAttempt->score }} / {{ $quizAttempt->quiz->number_of_questions }}</h2>
<h3>Answers:</h3>
<ul>
    @foreach ($quizAttempt->quizAnswers as $answer)
        <li>
            <strong>Question: {{ $answer->question->question_text }}</strong><br>
            <strong>Your Answer:</strong> {{ json_decode($answer->question->options)[$answer->selected_answer] }}<br>
            <strong>Correct Answer:</strong> {{ json_decode($answer->question->options)[$answer->question->correct_answer] }}<br>
            <strong>Status:</strong> {{ $answer->is_correct ? 'Correct' : 'Incorrect' }}
			{{-- @dump($answer->question->question_text, $answer->selected_answer, $answer->question->corre) --}}
        </li>
    @endforeach
</ul>

<a href="/">Back to My Home</a>
