@php
	$questions = $attempt->quiz->questions;
	$isAttemptCompleted = $attempt->completed_at ? true : false;
@endphp

<div
	x-data="{
		questionsCount: {{ $questions->count() }},
		questionIndex: 0,
	}"
>
	<form method="POST" action="{{ route('attempts.submit', ['quiz' => $quiz, 'attempt' => $attempt]) }}">
		@csrf
		@php
			if (!$isAttemptCompleted && $attempt->quiz->rules->shuffle_questions) {
				$questions = $questions->shuffle();
			}
		@endphp
		@foreach ($questions as $index => $question)
			@php $options = $question->options; @endphp
			<div 
				class="join join-vertical w-full"
				x-bind:class="{ 'hidden': questionIndex !== {{ $index }} }"
			>

				<!-- Question -->
				<div class="join-item card bg-base-100 shadow-xl border border-base-300">
					<div class="card-body">
						<div class="flex relative min-h-[5rem]">
							<div class="absolute bottom-0 top-0 bg-neutral rounded-box text-neutral-content p-2 flex justify-center items-center">
								<div class="flex justify-center items-center font-mono text-5xl min-w-[4rem] min-h-[4rem] max-w-[6rem] max-h-[6rem] overflow-y-hidden overflow-x-auto">
									{{ $index + 1 }}
								</div>
							</div>
							<div class="flex-1 flex justify-center items-center mx-28">
								<h2 class="text-4xl text-neutral-content font-bold">
									{{ $question->question_text }}
								</h2>
							</div>
						</div>


					</div>
				</div>

				@if (!$isAttemptCompleted)
					<!-- Options before attempt is completed -->
					<div class="join-item card bg-base-100 shadow-xl border border-base-300">
						<div class="card-body">
							<div class="flex flex-wrap gap-8 items-center justify-center mx-20" x-data="{checkedOptionId: 0}">
								@php
									if ($attempt->quiz->rules->shuffle_options) {
										$options = $options->shuffle();
									}
								@endphp
								@foreach ($options as $index => $option)
									<label>
										<input 
											hidden
											type="radio" 
											id="option-{{ $question->id }}"
											name="answers[{{ $question->id }}]" 
											value="{{ $option->id }}"
											class="radio radio-primary radio-sm sm:radio-md" 
											{{ old("answers.{$question->id}") == $option->id ? 'checked' : '' }}
											x-model="checkedOptionId"
										>
										<!-- Option Card -->
										<div class="card bg-base-200 hover:bg-primary/10 hover:border-primary/20 shadow-xl border-base-300 w-[14rem] h-[14rem]" x-bind:class="{ 'bg-primary/10 border border-primary/20': checkedOptionId == {{ $option->id }} }" x-bind:class="{ border-base-300': checkedOptionId != {{ $option->id }} }">
											<div class="card-body w-full h-full">
												<div class="flex flex-col w-full h-full justify-center items-center">
													<div class="flex w-full gap-2 justify-between items-center">
														<span class="font-mono rounded-full bg-neutral text-neutral-content h-6 w-6 flex justify-center items-center">
															@if ($index < 26)
																{{ chr($index + 65) }}
															@else
																{{ $index + 1 }}
															@endif
														</span>
													
													</div>
													<div class="flex justify-center items-center text-center w-full h-full overflow-y-auto break-words">
														{{ $option->option_text }}
													</div>
												</div>
											</div>
										</div>
									</label>
										@endforeach
							</div>
						</div>
					</div>
				@else
					@php 
						$correctOptionId = $question->options->where('is_correct', true)->first()->id;
					@endphp
					<!-- Options after attempt is completed -->
					<div class="join-item card bg-base-100 shadow-xl border border-base-300">
						<div class="card-body">
							<div class="flex flex-wrap gap-8 items-center justify-center mx-20">
								@foreach ($options as $index => $option)
									@php 
										$attemptAnswer = $attempt->answers->where('option_id', $option->id)->first();
										$isCorrect = $attemptAnswer && $attemptAnswer->option->is_correct;
										$successClass = 'bg-success/10 border border-success/20';
										$errorClass = 'bg-error/10 border border-error/20';
									@endphp
									<!-- Option Card -->
									<div class="card bg-base-200  shadow-xl border w-[14rem] h-[14rem]
										@if ($option->id == $correctOptionId)
											{{ $successClass }}
										@endif

										@if ($attemptAnswer && $isCorrect)
											{{ $successClass }}
										@elseif ($attemptAnswer)
											{{ $errorClass }}
										@else
											border-base-300	
										@endif
									">
										<div class="card-body w-full h-full">
											<div class="flex flex-col w-full h-full justify-center items-center">
												<div class="flex w-full gap-2 justify-between items-center">
													<span class="font-mono rounded-full bg-neutral text-neutral-content h-6 w-6 flex justify-center items-center">
														@if ($index < 26)
															{{ chr($index + 65) }}
														@else
															{{ $index + 1 }}
														@endif
													</span>
													@if ($attemptAnswer)
														@php 
															$successBadgeClass = 'badge-success/10 border border-success/20';
															$errorBadgeClass = 'badge-error/10 border border-error/20';
														@endphp
														<span class="badge badge-sm 
															@if ($attemptAnswer->option->is_correct)
																{{ $successBadgeClass }}
															@else
																{{ $errorBadgeClass }}
															@endif
														" x-show="$option->id == {{ $attemptAnswer->option_id }}">
															Your answer
														</span>
													@elseif ($option->id == $correctOptionId)
														<span class="badge badge-sm badge-success/10 border border-success/20">
															Correct answer
														</span>
													@endif 
												</div>
												<div class="flex justify-center items-center text-center w-full h-full overflow-y-auto break-words">
													{{ $option->option_text }}
												</div>
											</div>
										</div>
									</div>
								@endforeach
							</div>
						</div>
					</div>
				@endif
				<!-- Previous and Next Question Buttons -->
				<div class="join-item card bg-base-100 shadow-xl border border-base-300">
					<div class="card-body">
						<div class="flex items-center">
							<button 
								class="btn btn-neutral" 
								@click.prevent="questionIndex--"
								x-bind:disabled="questionIndex <= 0"
							>
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left"><path d="m15 18-6-6 6-6"/></svg>
							Previous
							</button>

							<div class="flex-1"></div>
						
							<button 
								class="btn btn-default" 
								@click.prevent="questionIndex++"
								x-bind:disabled="questionIndex >= questionsCount - 1"
							>
								Next
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
							</button>
							
							@if (!$isAttemptCompleted)
								<div class="divider divider-horizontal m-1"></div>
								
								<button id="submit-button" type="submit" class="btn btn-primary w-24" onclick="return confirm('Are you ready to submit your answers?')">
									Submit
								</button>
							@endif
						</div>
					</div>
				</div>
			</div>

		@endforeach
	</form>
</div>