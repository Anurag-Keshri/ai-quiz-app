<div class="card bg-base-100 shadow-xl mb-8 border border-base-300">
	<div class="card-body">
		<div class="flex flex-col md:flex-row justify-between gap-6">
			<!-- Quiz Title and Description -->
			<div class="flex-1">
				<h1 class="text-3xl font-bold mb-4">{{ $quiz->title }}</h1>
				<p class="text-base-content/70 mb-4">{{ $quiz->description }}</p>
				<div class="flex flex-wrap gap-2 mb-4">
					<div class="badge badge-primary">{{ $quiz->questions->count() }} Questions</div>
					<div class="badge badge-secondary">{{ $quiz->attempts->count() }} Attempts</div>
				</div>
				<div class="flex items-center gap-2 text-sm text-base-content/70">
					<div class="avatar placeholder">
						<div class="bg-neutral text-neutral-content w-8 rounded-full">
						  <span class="text-sm">
							{{ strtoupper(substr($quiz->author->name, 0, 2)) }}
						  </span>
						</div>
					</div>
					<span>Created by {{ $quiz->author->name }}</span>
					<span>•</span>
					<span>{{ $quiz->created_at->diffForHumans() }}</span>
				</div>
			</div>

			<!-- Action Buttons -->
			<div class="flex flex-col items-center justify-center gap-3">
				<a href="{{ route('attempts.create', $quiz) }}" class="btn btn-primary">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
						<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
					</svg>
					Take Quiz
				</a>
				@can('update', $quiz)
					<a href="{{ route('quizzes.edit', $quiz) }}" class="btn btn-outline">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
							<path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
						</svg>
						Edit Quiz
					</a>
				@endcan
			</div>
		</div>
	</div>
</div>