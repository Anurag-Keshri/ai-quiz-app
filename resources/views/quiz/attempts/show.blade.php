@extends('layouts.app')

@section('content')
	<div class="min-h-screen bg-base-200">
		<div class="container mx-auto p-4 flex flex-col gap-6">
			<!-- Quiz Info & Timer -->
			@include('quiz.attempts.partials.info')

			<!-- Quiz Questions -->
			@include('quiz.attempts.partials.questions')
		</div>
	</div>
@endsection