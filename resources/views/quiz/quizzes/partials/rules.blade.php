<div class="join join-vertical rounded-2xl">
	<!-- Quiz Info Card -->
	<div class="card bg-base-100 shadow-xl border border-base-300 join-item">
		<div class="card-body">
			<div class="flex justify-between gap-4">
				<h2 class="card-title text-2xl mb-4">Quiz Rules</h2>
			</div>
				
			<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
				<!-- Time Limit -->
				<div class="flex items-center gap-3">
					<div class="p-3 bg-primary/10 rounded-lg">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
						</svg>
					</div>
					<div>
						<div class="font-medium">Time Limit</div>
						<div class="text-sm text-base-content/70">
							{{ $quiz->rules->time_limit ? $quiz->rules->time_limit . ' minutes' : 'No time limit' }}
						</div>
					</div>
				</div>
	
				<!-- Start Date -->
				<div class="flex items-center gap-3">
					<div class="p-3 bg-primary/10 rounded-lg">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
						</svg>
					</div>
					<div>
						<div class="font-medium">Start Date</div>
						<div class="text-sm text-base-content/70">
							{{ $quiz->rules->start_date ? $quiz->rules->start_date->format('M j, Y') : 'No start date' }}
						</div>
					</div>
				</div>
	
				<!-- End Date -->
				<div class="flex items-center gap-3">
					<div class="p-3 bg-primary/10 rounded-lg">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
						</svg>
					</div>
					<div>
						<div class="font-medium">End Date</div>
						<div class="text-sm text-base-content/70">
							{{ $quiz->rules->end_date ? $quiz->rules->end_date->format('M j, Y') : 'No end date' }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Quiz Rules Card -->
	<div class="card bg-base-100 shadow-xl border border-base-300 join-item">
		<div class="card-body">
			
			<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
				@foreach([
					['Show Score', 'You will see your score after submission', $quiz->rules->show_score],
					['Shuffle Questions', 'Questions appear in random order', $quiz->rules->shuffle_questions],
					['Shuffle Options', 'Answer options are randomized', $quiz->rules->shuffle_options],
					['Show Answers', 'Correct answers shown after completion', $quiz->rules->show_correct_answer]
				] as [$title, $description, $enabled])
					<div class="flex items-start gap-3">
						<div class="mt-1">
							@if($enabled)
								<div class="badge badge-success badge-sm gap-2">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
									</svg>
								</div>
							@else
								<div class="badge badge-ghost badge-sm gap-2">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
									</svg>
								</div>
							@endif
						</div>
						<div>
							<div class="font-medium">{{ $title }}</div>
							<div class="text-sm text-base-content/70">{{ $description }}</div>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>
</div>
