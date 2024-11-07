@extends('layouts.app')

@section('content')
	<div class="min-h-screen bg-base-200">
		<div class="container mx-auto p-4 flex flex-col gap-6">
			<!-- Info Edit -->
			@include('quiz.quizzes.partials.info-edit')

			<!-- Rules Edit -->
			@include('quiz.quizzes.partials.rules-edit')
			
			<!-- Questions Edit -->
			@include('quiz.quizzes.partials.questions-edit')
		</div>
	</div>
@endsection