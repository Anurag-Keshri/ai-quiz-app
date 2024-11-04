@php
    // TODO: Cache/Preload these values and move to controller
    $attemptsCount = $attempts->count();
	$totalQuestions = 0;
    $totalScore = 0;
    $averageScore = 0;
    
    foreach ($attempts as $attempt) {
        $totalQuestions += $attempt->quiz->questions->count();
        $totalScore += $attempt->score;
    }
    
    if ($attemptsCount > 0) {
        $averageScore = round($totalScore / $totalQuestions * 100);
    }
@endphp

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
	<div class="stats shadow bg-base-100">
		<div class="stat">
			<div class="stat-title">Total Attempts</div>
			<div class="stat-value">{{ $attemptsCount }}</div>
			<div class="stat-desc">{{ isset($quiz) ? 'For this quiz' : 'Across all quizzes' }}</div>
		</div>
	</div>
	
	<div class="stats shadow bg-base-100">
		<div class="stat">
			<div class="stat-title">Average Score</div>
			<div class="stat-value">{{ $averageScore }}%</div>
			<div class="stat-desc">Out of 100%</div>
		</div>
	</div>

	<div class="stats shadow bg-base-100">
		<div class="stat">
			<div class="stat-title">Questions</div>
			<div class="stat-value">{{ isset($quiz) ? $quiz->questions->count() : $totalQuestions }}</div>
			<div class="stat-desc">{{ isset($quiz) ? 'In this quiz' : 'Total answered' }}</div>
		</div>
	</div>
</div>