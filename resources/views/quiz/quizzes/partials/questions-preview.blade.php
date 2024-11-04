<div class="card bg-base-100 shadow-xl border border-base-300">
	<div class="card-body">
		<h2 class="card-title text-2xl mb-6">Questions Preview</h2>

		<div class="join join-vertical w-full">
			@foreach($quiz->questions as $question)
				<details tabindex="0" class="collapse collapse-arrow join-item border border-base-200">
					<summary class="collapse-title text-xl font-medium peer-checked:bg-secondary peer-checked:text-secondary-content">
						<div class="flex items-center gap-3">
							<span class="badge badge-primary">{{ $loop->iteration }}</span>
							{{ $question->question_text }}
						</div>
					</summary>
					<div class="collapse-content peer-checked:bg-secondary peer-checked:text-secondary-content">
						<div class="mt-4 space-y-3">
							@foreach($question->options as $option)
								<div class="flex items-center gap-3 p-4 rounded-lg {{ $option->is_correct ? 'bg-success/10 border border-success/20' : 'bg-base-200' }}">
									@if($option->is_correct)
										<div class="badge badge-success gap-2">
											<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
												<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
											</svg>
											Correct
										</div>
									@else
										<div class="badge badge-ghost gap-2">
											<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
												<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
											</svg>
											Incorrect
										</div>
									@endif
									<span class="flex-1">{{ $option->option_text }}</span>
								</div>
							@endforeach
						</div>
					</div>
				</details>
			@endforeach
		</div>
	</div>
</div>