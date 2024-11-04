<div class="card bg-base-100 shadow-xl">
	<div class="overflow-x-auto">
		<!-- Desktop Table View -->
		<table class="table table-fixed table-zebra">
			<!-- Head -->
			<thead class="bg-base-200">
				<tr>
					<th class="">Title</th>
					<th class="">Questions</th>
					<th class="">Score</th>
					<th class="">Started At</th>
					<th class="">Completed At</th>
					<th class="">Actions</th>
				</tr>
			</thead>
			<!-- Body -->
			<tbody>
				@foreach($attempts as $index => $attempt)
					@php $quiz = $attempt->quiz; @endphp
					<tr class="hover">
						<!-- Quiz Title -->
						<td>
							<a class="link link-hover link-primary" href="{{ route('quizzes.show', $quiz) }}">
								<div class="font-medium text-ellipsis overflow-hidden whitespace-nowrap">{{ $quiz->title }}</div>
							</a>
							@if($quiz->description)
								<div class="text-sm text-base-content/70 hidden md:table-cell text-ellipsis overflow-hidden whitespace-nowrap">{{ Str::limit($quiz->description, 60) }}</div>
							@endif
						</td>
						<!-- Number of Questions -->
						<td class="hidden lg:table-cell">
							<div class="badge badge-outline">{{ $quiz->questions->count() }}  <span class="hidden xl:inline">&nbspQuestions</span></div>
						</td>
						<!-- Score -->
						<td>
							<div class="flex items-center gap-2">
								<!-- Score -->
								<span class="text-sm badge">{{ $attempt->score }}/{{ $quiz->questions->count() }}</span>
								<!-- Progress Bar -->
								@php
									$progress = $attempt->score / $quiz->questions->count() * 100;
									$progressColor = $progress <= 33 ? 'progress-error' : 'progress-success';
								@endphp
								<progress 
									class="progress {{ $progressColor }} hidden lg:block" 
									value="{{ $attempt->score }}" max="{{ $quiz->questions->count() }}">
								</progress>
							</div>
						</td>
						<!-- Started At -->
						<td>
							<div class="flex flex-col">
								<span class="text-sm">
									{{ $attempt->created_at->format('H:i') }}
								</span>
								<span class="text-sm">
									{{ $attempt->created_at->format('M d y') }}
								</span>
							</div>
						</td>
						<!-- Completed At -->
						<td>
							<div class="flex flex-col">
								<span class="text-sm">
									{{ $attempt->completed_at->format('H:i') }}
								</span>
								<span class="text-sm">
									{{ $attempt->completed_at->format('M d y') }}
								</span>
							</div>
						</td>
						<!-- Actions -->
						<td>
							<div class="flex items-center gap-2">
								<!-- Desktop Actions -->
								<div class="hidden md:flex items-center gap-2">
									<!-- View Attempt -->
									<a href="{{ route('attempts.show', [$quiz,$attempt]) }}" 
										class="btn btn-primary btn-sm">
										<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye">
											<path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/>
										</svg>
										<span class="hidden xl:inline">View</span>
									</a>
	
									<!-- Retake Quiz -->
									<a href="{{ route('attempts.create', $quiz) }}" 
										class="btn btn-neutral btn-sm">
										<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
										</svg>
										<span class="hidden xl:inline">Retake</span>
									</a>
	
									<!-- Delete Attempt -->
									@if(Gate::allows('delete', $attempt))
										<form action="{{ route('attempts.destroy', [$quiz,$attempt]) }}" 
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
												<span class="hidden xl:inline">Delete</span>
											</button>
										</form>
									@endif
								</div>
	
								<!-- Mobile Actions (Dropdown Menu) -->
								<div class="md:hidden dropdown {{ $index === 0 ? ' dropdown-bottom dropdown-end' : 'dropdown-top dropdown-end' }}">
									<label tabindex="0" class="btn btn-ghost btn-sm">
										<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
										</svg>
									</label>
									<ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow-lg bg-base-100 rounded-box w-52">
										<!-- View Attempt -->
										<li>
											<a href="{{ route('attempts.show', [$quiz,$attempt]) }}" class="flex items-center gap-2">
												<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye">
													<path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/>
												</svg>
												View Attempt
											</a>
										</li>
	
										<!-- Retake Quiz -->
										<li>
											<a href="{{ route('attempts.create', $quiz) }}" class="flex items-center gap-2">
												<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
												</svg>
												Retake Quiz
											</a>
										</li>
										@if(Gate::allows('delete', $attempt))
											<div class="divider my-1"></div>
											<li>
												<form action="{{ route('attempts.destroy', [$quiz,$attempt]) }}" 
													method="POST" 
													onsubmit="return confirm('Are you sure you want to delete this attempt?');"
													class="w-full">
													@csrf
													@method('DELETE')
													<button type="submit" class="flex items-center gap-2 text-error hover:bg-error/10">
														<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
															<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
														</svg>
														Delete Attempt
													</button>
												</form>
											</li>
										@endif
									</ul>
								</div>
							</div>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
