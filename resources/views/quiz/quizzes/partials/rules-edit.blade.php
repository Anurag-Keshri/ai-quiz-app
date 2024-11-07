@php
    $quizRules = $quiz->rules;
@endphp
<div class="join join-vertical rounded-2xl">
	<div class="join-item card bg-base-100 shadow-xl border border-base-300">
		<div class="card-body p-6">
			<h2 class="card-title text-2xl mb-4">Quiz Rules</h2>
			<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
				<!-- Time Limit -->
				<div class="form-control flex-1">
					<label class="label">
						<span class="label-text font-medium">Time Limit</span>
					</label>
					<div class="flex">
						<input 
							type="number" 
							name="rules[time_limit]" 
							class="input input-bordered rounded-lg rounded-r-none w-full @error('time_limit') input-error @enderror" 
							value="{{ old('time_limit', $quizRules->time_limit) }}"
							placeholder="Enter time" 
							form="save-quiz-form"
						/>	
						<span class="btn rounded-l-none no-animation pointer-events-none">minutes</span>
					</div>
					@error('time_limit')
						<label class="label">
							<span class="label-text-alt text-error">{{ $message }}</span>
						</label>
					@enderror
				</div>

				<!-- Start Date -->
				<div class="form-control">
					<label class="label">
						<span class="label-text font-medium">Start Date</span>
					</label>
					<input 
						type="datetime-local" 
						name="rules[start_date]" 
						class="input input-bordered w-full @error('start_date') input-error @enderror" 
						value="{{ old('start_date', $quizRules->start_date) }}" 
						form="save-quiz-form"
					/>
					@error('start_date')
						<label class="label">
							<span class="label-text-alt text-error">{{ $message }}</span>
						</label>
					@enderror
				</div>

				<!-- End Date -->
				<div class="form-control">
					<label class="label">
						<span class="label-text font-medium">End Date</span>
					</label>
					<input 
						type="datetime-local" 
						name="rules[end_date]" 
						class="input input-bordered w-full @error('end_date') input-error @enderror" 
						value="{{ old('end_date', $quizRules->end_date) }}" 
						form="save-quiz-form"
					/>
					@error('end_date')
						<label class="label">
							<span class="label-text-alt text-error">{{ $message }}</span>
						</label>
					@enderror
				</div>
			</div>
		</div>
	</div>

	<div class="join-item card bg-base-100 shadow-xl border border-base-300">
		<div class="card-body p-6">
			<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
				@foreach([
					'show_score' => ['Show Score', 'Show score after submission', 'Users can see their final score immediately after completing the quiz'],
					'shuffle_questions' => ['Shuffle Questions', 'Randomize question order', 'Questions appear in a different order for each attempt'],
					'shuffle_options' => ['Shuffle Options', 'Randomize answer order', 'Answer options are presented in a random order for each attempt'],
					'show_correct_answer' => ['Show Answers', 'Show correct answers', 'Display correct answers after quiz completion']
				] as $key => $details)
					<div class="card bg-base-200">
						<div class="card-body p-6">
							<label class="cursorspace-y-2">
								<div class="flex items-center justify-between gap-4">
									<div>
										<h3 class="font-medium">{{ $details[0] }}</h3>
										<p class="text-sm text-base-content/70 mt-1">{{ $details[1] }}</p>
									</div>
									<input 
										type="checkbox"
										name="rules[{{ $key }}]"
										class="toggle toggle-success"
										value="1"
										{{ old($key, $quizRules->$key) ? 'checked' : '' }} 
										form="save-quiz-form"
									/>
								</div>
							</label>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>
</div>