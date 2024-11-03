@extends('layouts.app')

@section('content')
	<div class="min-h-screen bg-base-200">
		@include('home.partials.hero-section')

		<div class="container mx-auto px-4 py-12 flex flex-col gap-12">
			@include('home.partials.stats-section')

			@include('home.partials.features-section')
			
			@include('home.partials.recent-quizzes-section')
		</div>
	</div>
@endsection

