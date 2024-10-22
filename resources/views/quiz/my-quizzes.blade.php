
<div class="container">
<h1>My Quizzes</h1>

	@if ($quizzes->isEmpty())
		<p>No quizzes found.</p>
	@else
		<ul>
			@foreach ($quizzes as $quiz)
				<li>
					<strong>Title:</strong> {{ $quiz->title }}<br>
					<strong>Created At:</strong> {{ $quiz->created_at->format('d-m-Y H:i:s') }}<br>
					<a href="{{ route('quiz.edit', $quiz->id) }}">Edit Quiz</a> | 
					<a href="{{ route('quiz.take', $quiz->id) }}">Take Quiz</a>
				</li>
			@endforeach
		</ul>
	@endif

</div>
