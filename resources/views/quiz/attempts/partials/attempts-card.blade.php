@php
	$backgroundColor = $backgroundColor ?? 'base-100';
	$borderColor = $borderColor ?? 'base-300';
	$myAttempts = $myAttempts ?? true;
	$progress = round($attempt->score / $attempt->quiz->questions->count() * 100);
	$progressColor = $progress <= 40 ? 'error' : 'success';
@endphp

<div class="card bg-{{ $backgroundColor }} shadow-xl border border-{{ $borderColor }}">
	<div class="card-body">
		<!-- Header -->
		<div class="flex justify-between items-start">
			@if($myAttempts)
				<div>
					<h3 class="card-title">{{ $attempt->quiz->title }}</h3>
					<p class="text-base-content/70 mt-1">{{ $attempt->quiz->description }}</p>
				</div>
			@else
				<div>
					<h3 class="card-title">{{ $attempt->user->name }}</h3>
					<p class="text-base-content/70 mt-1">{{ $attempt->user->email }}</p>
				</div>
			@endif
			<div class="radial-progress text-{{ $progressColor }}" style="--value:{{ $progress }};" role="progressbar">
				{{ $progress }}%
			</div>
		</div>

		<!-- Quiz Details -->
		<div class="grid grid-cols-1  gap-4 mt-4">
			<div class="flex items-center gap-2">
				<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-hash"><line x1="4" x2="20" y1="9" y2="9"/><line x1="4" x2="20" y1="15" y2="15"/><line x1="10" x2="8" y1="3" y2="21"/><line x1="16" x2="14" y1="3" y2="21"/></svg>
				<span>Score: <span class="ml-1 badge badge-outline badge-{{ $progressColor }} badge-lg">{{ $attempt->score }} / {{ $attempt->quiz->questions->count() }}</span></span>
			</div>

			<div class="flex items-center gap-2">
				<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-play"><circle cx="12" cy="12" r="10"/><polygon points="10 8 16 12 10 16 10 8"/></svg>
				<span>Started: {{ $attempt->created_at->format('M d, Y H:i') }}</span>
			</div>

			<div class="flex items-center gap-2">
				<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-success" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
				<span>Completed: {{ $attempt->completed_at?->format('M d, Y H:i') ?? 'In Progress' }}</span>
			</div>
		</div>

		<!-- Actions -->
		<div class="card-actions justify-end mt-4">
			<div class="flex items-center gap-2">
				<!-- View Attempt -->
				<a href="{{ route('attempts.show', [$attempt->quiz, $attempt]) }}" 
					class="btn btn-primary btn-sm">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye">
						<path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/>
					</svg>
					<span class="hidden min-[400px]:block">View</span>
				</a>

				<!-- Retake Quiz -->
				<a href="{{ route('attempts.create', $attempt->quiz) }}" 
					class="btn btn-neutral btn-sm">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
					</svg>
					<span class="hidden min-[400px]:block">Retake</span>
				</a>
				
				
				<!-- Delete Attempt -->
				@if(Gate::allows('delete', $attempt))
					<div class="divider divider-horizontal mx-2"></div>

					<form action="{{ route('attempts.destroy', [$attempt->quiz, $attempt]) }}" 
						method="POST" 
						onsubmit="return confirm('Are you sure you want to delete this attempt?');"
						class="w-full"
					>
						@csrf
						@method('DELETE')
						<button type="submit" class="btn btn-outline btn-error btn-sm">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
							</svg>
							<span class="hidden sm:block">Delete</span>
						</button>
					</form>
				@endif
			</div>
		</div>
	</div>
</div>
