<div class="card bg-base-100 shadow-xl border border-base-300">
	<div class="card-body">
		<h2 class="card-title text-2xl mb-6">Questions Preview</h2>

		@if($quiz->questions->isEmpty())
			<p class="text-center text-lg">No questions found for this quiz.</p>
		@else	
			<div class="border border-base-200 rounded-lg">
				@foreach($quiz->questions as $question)
					<div class="border-b border-base-200">
						<div class="flex items-center gap-3 p-4">
							<span class="badge badge-primary">{{ $loop->iteration }}</span>
							<input form="save-quiz-form" name="questions[{{ $question->id }}][question_text]" type="text" value="{{ $question->question_text }}" class="input input-ghost w-full text-xl font-medium p-0" />
						</div>
						<div class="p-4 space-y-3" x-data="{ correctOption: {{ $question->options->where('is_correct', true)->first()->id }} }">
							@foreach($question->options as $option)
								<div class="flex items-center gap-3 p-4 rounded-lg" x-bind:class="{ 'bg-success/10 border border-success/20': correctOption == {{ $option->id }} }">
									<label>
										<input type="radio" name="questions[{{ $question->id }}][options][{{ $option->id }}][is_correct]" value="{{ $option->id }}" x-model="correctOption" hidden form="save-quiz-form"/>
										<div x-show="correctOption == {{ $option->id }}" class="badge badge-success gap-2">
											<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
												<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
											</svg>
											Correct
										</div>
										<div x-show="correctOption != {{ $option->id }}" class="badge badge-ghost gap-2">
											<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
												<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
											</svg>
											Incorrect
										</div>
									</label>
									<input form="save-quiz-form" name="questions[{{ $question->id }}][options][{{ $option->id }}][option_text]" type="text" value="{{ $option->option_text }}" class="input input-ghost w-full p-0" />
								</div>
							@endforeach
						</div>
					</div>
				@endforeach
			</div>
		@endif
	</div>
</div>