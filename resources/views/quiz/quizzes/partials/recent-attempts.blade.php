<div class="card bg-base-100 shadow-xl border border-base-300">
	<div class="card-body">
		<div class="flex justify-between items-center mb-6">
			<h2 class="card-title text-2xl">Recent Attempts</h2>
			<a href="{{ route('attempts.indexForQuiz', ['quiz' => $quiz->id]) }}" class="btn btn-outline btn-sm">
				View All
			</a>
		</div>
		<!-- Recent Attempts Cards-->
		@if($quiz->attempts->isEmpty())
			<div class="card bg-base-200 shadow-xl">
				<div class="card-body items-center text-center">
					<h2 class="card-title text-2xl mb-4">No Attempts Yet</h2>
					<p class="mb-4">You haven't attempted any quizzes yet!</p>
					<a href="{{ route('quizzes.index') }}" class="btn btn-primary">Browse Quizzes</a>
				</div>
			</div>
		@else
			<!-- Stats Cards -->
			@include('quiz.quizzes.partials.stats-cards')

			<!-- Recent Attempts Cards -->
			<div class="grid grid-cols-1 gap-4 lg:grid-cols-2 xl:grid-cols-3 mt-4">
				@foreach($quiz->attempts->take(3)->reverse() as $attempt)
					@include('quiz.attempts.partials.attempts-card', ['attempt' => $attempt, 'myAttempts' => false, 'backgroundColor' => 'base-200', 'borderColor' => 'base-300'])
				@endforeach
			</div>
		@endif
	</div>
</div>