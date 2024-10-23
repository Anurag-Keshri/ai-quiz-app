<h1>Edit Quiz</h1>

<!-- Display Quiz Title -->
<h2>{{ $quiz->title }}</h2>
@php
	// dd( json_decode($quiz->questions[0]->options));
@endphp
<!-- Loop through each question and display it with options -->
@foreach ($quiz->questions as $question)
    <div>
        <h3>Question {{ $loop->iteration }}: {{ $question->question_text }}</h3>
        <ul>
            @foreach (json_decode($question->options) as $index => $option)
                <li>
                    <label>
                        <input type="radio" name="question_{{ $question->id }}" value="{{ $option }}"
                               {{ $index == $question->correct_answer ? 'checked' : '' }}>
                        {{ $option }}
                    </label>
                </li>
            @endforeach
        </ul>
    </div>
@endforeach

<!-- Submit Button -->
<button type="submit">Submit Quiz</button>
