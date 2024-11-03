@auth
	<!-- Recent Quizzes Section -->
	<div class="mb-16">
		<div class="flex justify-between items-center mb-6">
			<h2 class="text-3xl font-bold">Recent Quizzes</h2>
			<a href="{{ route('quizzes.index') }}" class="btn btn-outline btn-sm">
				View All
			</a>
		</div>

		@if(count($quizzes) === 0)
			<div class="card bg-base-100 shadow-xl border border-base-300">
				<div class="card-body items-center text-center">
					<h3 class="card-title text-2xl mb-4">No Quizzes Yet</h3>
					<p class="mb-4">Be the first to create a quiz!</p>
					<a href="{{ route('quizzes.create') }}" class="btn btn-primary">Create Quiz</a>
				</div>
			</div>
		@else
			@include('quiz.quizzes.partials.quizzes-table')
		@endif
	</div>
@endauth