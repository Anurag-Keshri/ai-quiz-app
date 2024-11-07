<div class="card bg-base-100 shadow-xl border border-base-300">
	<div class="card-body">
		<div class="flex flex-col md:flex-row justify-between gap-6">
			<!-- Quiz Title and Description -->
			<div class="flex flex-col flex-1">
				<h1 class="text-3xl font-bold mb-4">
					<input form="save-quiz-form" name="title" type="text" value="{{ $quiz->title }}" class="input input-ghost w-full text-3xl font-bold p-0" />
				</h1>
				<p class="text-base-content/70 mb-4">
					<input form="save-quiz-form" name="description" type="text" value="{{ $quiz->description }}" class="input input-ghost w-full p-0" />
				</p>
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
				<!-- Save Quiz -->
				<div class="tooltip tooltip-primary w-full" data-tip="Save Quiz">
					<form 
						action="{{ route('quizzes.update', $quiz) }}" 
						method="POST"
						id="save-quiz-form"
					>
						@csrf
						@method('PUT')
						<button type="submit" class="btn btn-primary w-full">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-save"><path d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"/><path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7"/><path d="M7 3v4a1 1 0 0 0 1 1h7"/></svg>
							Save
						</button>
					</form>
				</div>
				
				<!-- Delete Quiz -->
				<div class="tooltip  tooltip-error" data-tip="Delete Quiz">
					<form 
						action="{{ route('quizzes.destroy', $quiz) }}" 
						method="POST" 
						onsubmit="return confirm('Are you sure you want to delete this quiz?');"
					>
						@csrf
						@method('DELETE')
						<button type="submit" class="btn btn-outline btn-error join-item w-full">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
							Delete
						</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>