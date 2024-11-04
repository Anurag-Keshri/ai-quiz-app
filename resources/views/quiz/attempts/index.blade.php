@extends('layouts.app')

@section('content')
	<div class="container mx-auto p-4">
		<!-- Stats Overview -->
		@include('quiz.attempts.partials.attempts-stats')

		<!-- Attempts Table -->
		@if($attempts->isEmpty())
			<div class="card bg-base-100 shadow-xl">
				<div class="card-body items-center text-center">
					<h2 class="card-title text-2xl mb-4">No Attempts Yet</h2>
					<p class="mb-4">You haven't attempted any quizzes yet!</p>
					<a href="{{ route('quizzes.index') }}" class="btn btn-primary">Browse Quizzes</a>
				</div>
			</div>
		@else
			<div class="grid grid-cols-1 gap-4 lg:grid-cols-2 xl:grid-cols-3">
				@foreach($attempts as $attempt)
					@include('quiz.attempts.partials.attempts-card', ['attempt' => $attempt])
				@endforeach
			</div>
		@endif
	</div>
@endsection