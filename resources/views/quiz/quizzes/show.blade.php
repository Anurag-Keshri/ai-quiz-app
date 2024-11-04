@extends('layouts.app', ['navTitle' => 'View Quiz'])

@section('content')
<div class="min-h-screen bg-base-200">
    <div class="container mx-auto p-4">
        <!-- Quiz Info Card -->
		@include('quiz.quizzes.partials.info-card')

        <!-- Stats Cards -->
		@include('quiz.quizzes.partials.stats-cards')

		@if(Gate::allows('update', $quiz))
			<!-- Questions Preview Card -->
			@include('quiz.quizzes.partials.questions-preview')

			<!-- Recent Attempts Cards-->
			@include('quiz.quizzes.partials.recent-attempts-cards')
		@endif
    </div>
</div>
@endsection