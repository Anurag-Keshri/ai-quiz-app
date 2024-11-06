@php
	$quiz = $attempt->quiz;
	$isAttemptCompleted = $attempt->completed_at ? true : false;
	$attemptStatus = $isAttemptCompleted ? 'Completed' : ($attempt->created_at ? 'In Progress' : 'Not Started');
	$timeLimit = ($quiz->rules->time_limit * 60) - $attempt->created_at->diffInSeconds(now());
@endphp



<div class="card bg-base-100 shadow-xl border border-base-300">
	<div class="card-body">
		<div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
			<!-- Quiz Info -->
			<div class="flex flex-row justify-between md:flex-col flex-1">
				<div>
					<h1 class="text-3xl font-bold mb-4">{{ $quiz->title }}</h1>
					<p class="hidden md:block text-base-content/70 mb-4">{{ $quiz->description }}</p>
				</div>
				<div class="flex flex-col md:flex-row justify-between items-end md:justify-start flex-wrap gap-2 mb-4">
					<div class="badge badge-primary">
						{{ $quiz->questions->count() }} &nbsp;
						<span class="hidden min-[420px]:inline">Question(s)</span>
					</div>
					@if($attemptStatus == 'Completed')
						<span class="text-sm badge badge-success">
							<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
							<span class="hidden min-[420px]:inline">Completed</span>
						</span>
					@elseif($attemptStatus == 'In Progress')
						<span class="text-sm badge badge-warning">
							<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-timer"><line x1="10" x2="14" y1="2" y2="2"/><line x1="12" x2="15" y1="14" y2="11"/><circle cx="12" cy="14" r="8"/></svg>
							<span class="hidden min-[420px]:inline">In Progress</span>
						</span>
					@else
						<span class="text-sm badge badge-error">
							<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-slash"><circle cx="12" cy="12" r="10"/><line x1="9" x2="15" y1="15" y2="9"/></svg>
							<span class="hidden min-[420px]:inline">Not Started</span>
						</span>
					@endif
				</div>
			</div>
			@if(!$isAttemptCompleted)
				<!-- Timer -->
				<div 
					class="grid auto-cols-max grid-flow-col gap-5 text-center items-center justify-center md:justify-end"
					x-data="{
						timerLimit: {{ $timeLimit }},
						hours: 99,
						minutes: 99,
						seconds: 99,
						initTimer() {
							setInterval(() => { 
								this.timerLimit--;
								this.hours = Math.floor(this.timerLimit / 3600);
								this.minutes = Math.floor((this.timerLimit % 3600) / 60);
								this.seconds = this.timerLimit % 60;
							}, 1000);
						},
						submitForm() {
							document.getElementById('submit-button').click();
						}
					}" 
					x-init="initTimer();"
					x-effect="if (timerLimit <= 0) submitForm();"
				>
					<div class="bg-neutral rounded-box text-neutral-content flex flex-col p-2">
						<span class="countdown font-mono text-5xl">
							<span x-effect="$el.style.setProperty('--value', hours)"></span>
						</span>
						hours
					</div>
					<div class="bg-neutral rounded-box text-neutral-content flex flex-col p-2">
						<span x-bind:class="minutes < 2 ? 'text-error' : ''" class="countdown font-mono text-5xl">
							<span x-effect="$el.style.setProperty('--value', minutes)"></span>
						</span>
						min
					</div>
					<div class="bg-neutral rounded-box text-neutral-content flex flex-col p-2">
						<span x-bind:class="minutes < 2 ? 'text-error' : ''" class="countdown font-mono text-5xl">
							<span x-effect="$el.style.setProperty('--value', seconds)"></span>
						</span>
						sec
					</div>
				</div>
			@else
				<!-- Quiz Result -->
				@php 
					$questionsCount = $quiz->questions->count();
					$score = $attempt->score;
					$scorePercentage = round(($score / $questionsCount) * 100);
					$progressColor = $scorePercentage >= 66 ? 'success' : ($scorePercentage >= 33 ? 'warning' : 'error');
				@endphp
				<div class="flex flex-col justify-self-end items-end gap-4">
					<div class="flex justify-center items-center rounded-full">
						<p class="text-4xl font-bold">Score: {{ $score }} / {{ $questionsCount }}</p>
					</div>
					<div class="">
						<progress class="progress w-64 progress-{{ $progressColor }}" value="{{ $scorePercentage }}" max="100"></progress>
					</div>
				</div>
			@endif
		</div>
	</div>
</div>