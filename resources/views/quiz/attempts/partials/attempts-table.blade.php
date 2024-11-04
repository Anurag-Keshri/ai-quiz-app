<div class="card bg-base-100 shadow-xl">
	<div class="overflow-x-auto">
		<table class="table table-zebra">
			<!-- head -->
			<thead class="bg-base-200">
				<tr>
					<th>User</th>
					<th>Title</th>
					<th>Questions</th>
					<th>Attempts</th>
					<th class="hidden lg:table-cell">Created</th>
					<th class="w-1/3">Actions</th>
				</tr>
			</thead>
			<!-- body -->
			<tbody>
				@foreach($attempts as $index => $attempt)
					@php
						$quiz = $attempt->quiz;
					@endphp
					<tr class="hover">
						<td>
							<div class="font-medium">{{ $attempt->user->name }}</div>
						</td>
						<td>
							<a class="link link-hover link-primary" href="{{ route('quizzes.show', $quiz) }}">
								<div class="font-medium">{{ $quiz->title }}</div>
							</a>
							@if($quiz->description)
								<div class="text-sm text-base-content/70 hidden md:table-cell">{{ Str::limit($quiz->description, 60) }}</div>
							@endif
						</td>
						<td>
							<div class="badge badge-outline">{{ $quiz->questions->count() }}  <span class="hidden xl:inline">&nbspQuestions</span></div>
						</td>
						<td class="text-sm text-base-content/70"> 
							{{ $quiz->attempts->count() }} 
							<span class="hidden xl:inline">&nbspAttempts</span>
						</td>
						<td class="text-sm text-base-content/70 hidden lg:table-cell">
							{{ $quiz->created_at->diffForHumans() }}
						</td>
						<td>
							<div class="flex items-center gap-2">
								<!-- Share Quiz - Always Visible -->
								<button onclick="share_quiz_{{ $quiz->id }}.showModal()" 
										class="btn btn-primary btn-sm">
									<span class="hidden lg:inline">Share Quiz</span>
									<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
									</svg>
								</button>

								<!-- Desktop Actions -->
								<div class="hidden sm:flex items-center gap-2">
									<a href="{{ route('attempts.create', $quiz) }}" 
										class="btn btn-neutral btn-sm">
										<span class="hidden xl:inline">Take Quiz</span>
										<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
										</svg>
									</a>

									<a @disabled(Gate::denies('update', $quiz)) href="{{ route('quizzes.edit', $quiz) }}" 
										class="btn btn-outline btn-sm">
										<span class="hidden xl:inline">Edit</span>
										<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
										</svg>
									</a>
								</div>

								<!-- Dropdown Menu (Different content for mobile and desktop) -->
								<div class="dropdown {{ $index === 0 ? ' dropdown-bottom dropdown-end' : 'dropdown-top dropdown-end' }}">
									<label tabindex="0" class="btn btn-ghost btn-sm">
										<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
										</svg>
									</label>
									<ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow-lg bg-base-100 rounded-box w-52">
										<!-- Mobile-only actions -->
										<li class="md:hidden">
											<a href="{{ route('attempts.create', $quiz) }}" class="flex items-center gap-2">
												<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
												</svg>
												Take Quiz
											</a>
										</li>
										@if(Gate::allows('update', $quiz))
											<li class="md:hidden">
												<a href="{{ route('quizzes.edit', $quiz) }}" class="flex items-center gap-2">
													<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
														<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
													</svg>
													Edit Quiz
												</a>
											</li>

											<!-- Always visible in dropdown -->
											<li>
												<a href="{{ route('attempts.indexForQuiz', $quiz) }}" class="flex items-center gap-2">
													<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
														<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
													</svg>
													View Results
												</a>
											</li>
											<div class="divider my-1"></div>
											<li>
												<form action="{{ route('quizzes.destroy', $quiz) }}" 
													method="POST" 
													onsubmit="return confirm('Are you sure you want to delete this quiz?');"
													class="w-full">
													@csrf
													@method('DELETE')
													<button type="submit" class="flex items-center gap-2 text-error hover:bg-error/10">
														<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
															<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
														</svg>
														Delete Quiz
													</button>
												</form>
											</li>
										@else
											<li class="hidden md:block">
												<a href="{{ route('attempts.create', $quiz) }}" class="flex items-center gap-2">
													<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
														<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
													</svg>
													Take Quiz
												</a>
											</li>
										@endif
									</ul>
								</div>
							</div>
						</td>
					</tr>

					<!-- Share Modal for each quiz -->
					<dialog id="share_quiz_{{ $quiz->id }}" class="modal modal-bottom sm:modal-middle">
						<div class="modal-box"
								x-data="{
								copyStatus: {},
								showAlert: false,
								alertMessage: '',
								
								async copyToClipboard(text, type) {
									await navigator.clipboard.writeText(text);
									this.copyStatus[type] = true;
									this.showAlert = true;
									this.alertMessage = type === 'link' ? 'Share link copied!' : 'Access code copied!';
									
									setTimeout(() => {
										this.copyStatus[type] = false;
									}, 2000);
									
									setTimeout(() => {
										this.showAlert = false;
									}, 3000);
								}
							}">
							
							<div class="flex justify-between items-center">
								<h3 class="font-bold text-lg">Share Quiz: {{ $quiz->title }}</h3>
								<div class="modal-action mt-0">
									<form method="dialog">
										<button class="btn">Close</button>
									</form>
								</div>
							</div>

							<!-- Alert Notification -->
							<div class="relative">
								<div class="absolute top-0 left-0 right-0"
										x-show="showAlert">
									<div class="alert alert-success shadow-lg">
										<svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
										</svg>
										<span x-text="alertMessage"></span>
									</div>
								</div>
							</div>
							


							<div class="space-y-6 mt-4">
								<!-- Public Link -->
								<div>
									<label class="label">
										<span class="label-text font-medium">Public Link</span>
									</label>
									<div class="join w-full">
										<input type="text" 
												class="join-item input input-bordered w-full"
												value="{{ route('attempts.create', $quiz) }}" 
												readonly />
										<button class="btn join-item"
												@click="copyToClipboard('{{ route('attempts.create', $quiz) }}', 'link')">
											<template x-if="!copyStatus.link">
												<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-2M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
												</svg>
											</template>
											<template x-if="copyStatus.link">
												<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
												</svg>
											</template>
										</button>
									</div>
								</div>

								<!-- Access Code -->
								<div>
									<label class="label">
										<span class="label-text font-medium">Access Code</span>
									</label>
									<div class="join w-full">
										<input type="text" 
												class="join-item input input-bordered w-full font-mono"
												value="{{ $quiz->id }}" 
												readonly />
										<button class="btn join-item"
												@click="copyToClipboard('{{ $quiz->id }}', 'code')">
											<template x-if="!copyStatus.code">
												<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-2M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
												</svg>
											</template>
											<template x-if="copyStatus.code">
												<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
												</svg>
											</template>
										</button>
									</div>
								</div>
							</div>

						</div>
						<form method="dialog" class="modal-backdrop">
							<button>close</button>
						</form>
					</dialog>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
