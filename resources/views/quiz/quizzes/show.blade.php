@extends('layouts.app', ['navTitle' => 'View Quiz'])

@section('content')
<div class="min-h-screen bg-base-200">
    <div class="container mx-auto p-4 flex flex-col gap-6">
        <!-- Quiz Info Card -->
		@include('quiz.quizzes.partials.info-card')
		


		<!-- Quiz Rules Card -->
		@include('quiz.quizzes.partials.rules-card')
		
		@if(Gate::allows('update', $quiz))

			<!-- Questions Preview Card -->
			@include('quiz.quizzes.partials.questions-preview')

			<!-- Recent Attempts Heading -->
			@include('quiz.quizzes.partials.recent-attempts')
		@endif
    </div>
</div>
@endsection