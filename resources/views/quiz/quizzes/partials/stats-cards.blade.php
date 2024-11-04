@php
	// TODO: Move this to the controller
	$totalAttempts = $quiz->attempts->count();
	$totalQuestions = $quiz->questions->count();
	$averageScore = round($quiz->attempts->avg('score'), 1);
	$averageScorePercentage = round($averageScore / $totalQuestions * 100, 1);
	$highestScore = $totalAttempts ?? $quiz->attempts->max('score');
	$highestScorePercentage = round($highestScore / $totalQuestions * 100, 1);
	$completionRate = $totalAttempts ?? round(($quiz->attempts->whereNotNull('completed_at')->count() / $totalAttempts) * 100, 1);
@endphp

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
	<div class="stats shadow bg-base-200 border border-base-300">
		<div class="stat">
			<div class="stat-title">Average Score</div>
			@if($totalAttempts)
				<div class="stat-value">({{ $averageScore }}) : {{ $averageScorePercentage }}%</div>
				<div class="stat-desc">Based on {{ $totalAttempts }} attempts</div>
			@else
				<div class="stat-value text-sm">No attempts yet.</div>
			@endif
		</div>
	</div>

	<div class="stats shadow bg-base-200 border border-base-300">
		<div class="stat">
			<div class="stat-title">Highest Score</div>
			@if($totalAttempts)
				<div class="stat-value">({{ $highestScore }}) : {{ $highestScorePercentage }}%</div>
				<div class="stat-desc">Best performance</div>
			@else
				<div class="stat-value text-sm">No attempts yet.</div>
			@endif
		</div>
	</div>

	<div class="stats shadow bg-base-200 border border-base-300">
		<div class="stat">
			<div class="stat-title">Completion Rate</div>
			@if($totalAttempts)
				<div class="stat-value">({{ $totalAttempts }}) : {{ $completionRate }}%</div>
				<div class="stat-desc">Of quiz views</div>
			@else
				<div class="stat-value text-sm">No attempts yet.</div>
			@endif
		</div>
	</div>
</div>