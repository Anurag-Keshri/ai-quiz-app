@extends('layouts.app')

@section('content')
	<div class="min-h-screen bg-base-200">
		<div class="container mx-auto p-4 flex flex-col gap-6">
			<!-- Quiz Info & Timer -->
			@include('quiz.attempts.partials.info')

			@if (!$attempt->completed_at || $attempt->quiz->rules->show_correct_answer)
				<!-- Quiz Questions -->
				@include('quiz.attempts.partials.questions')
			@else
				<!-- Thank you -->
				<div class="card bg-base-100 shadow-xl border border-base-300">
					<div class="card-body">
						<div class="flex justify-between items-center">
							<h2 class="card-title">Thank you for completing the quiz!</h2>
							<div class="flex flex-col gap-4 justify-center items-center">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-lock-keyhole"><circle cx="12" cy="16" r="1"/><rect x="3" y="10" width="18" height="12" rx="2"/><path d="M7 10V7a5 5 0 0 1 10 0v3"/></svg>
								<h2 class="badge">Answers are hidden this quiz.</h2>
							</div>
						</div>
					</div>
				</div>
			@endif
		</div>
	</div>
@endsection