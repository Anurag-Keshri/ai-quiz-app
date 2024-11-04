<div class="card bg-base-100 shadow-xl border border-base-300">
	<div class="card-body">
		<div class="flex flex-col md:flex-row justify-between gap-6">
			<!-- Quiz Title and Description -->
			<div class="flex flex-col flex-1">
				<h1 class="text-3xl font-bold mb-4">{{ $quiz->title }}</h1>
				<p class="text-base-content/70 mb-4">{{ $quiz->description }}</p>
				<div class="flex flex-wrap gap-2 mb-4">
					<div class="badge badge-primary">{{ $quiz->questions->count() }} Questions</div>
					<div class="badge badge-secondary">{{ $quiz->attempts->count() }} Attempts</div>
					@if($quiz->rules->end_date && now()->isAfter($quiz->rules->end_date))
						<span class="text-sm badge badge-error">Ended</span>
					@elseif($quiz->rules->start_date && now()->isBefore($quiz->rules->start_date))
						<span class="text-sm badge badge-warning">Not Started</span>
					@else
						<span class="text-sm badge badge-success">Active</span>
					@endif
				</div>
				<div class="flex-1"></div>
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
				<a href="{{ route('attempts.create', $quiz) }}" class="btn btn-neutral w-full">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
						<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
					</svg>
					Take Quiz
				</a>
				@include('quiz.quizzes.partials.share-quiz-modal', ['quiz' => $quiz])
				<button onclick="share_quiz_{{ $quiz->id }}.showModal()" class="btn btn-primary w-full">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-share-2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"/><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"/></svg>
					Share Quiz
				</button>
				@can('update', $quiz)
					<div class="join w-full">
						<div class="tooltip flex-1" data-tip="Edit Quiz">	
							<a href="{{ route('quizzes.edit', $quiz) }}" class="btn btn-outline join-item w-full">
								<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
							</a>
						</div>
						<div class="tooltip  tooltip-error" data-tip="Delete Quiz">
							<form action="{{ route('quizzes.destroy', $quiz) }}" 
								method="POST" 
								onsubmit="return confirm('Are you sure you want to delete this quiz?');"
								class="w-full">
								@csrf
								@method('DELETE')
								<button type="submit" class="btn btn-outline btn-error join-item">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
								</button>
							</form>
						</div>
					</div>
				@endcan
			</div>
		</div>
	</div>
</div>