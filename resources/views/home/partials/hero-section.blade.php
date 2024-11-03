<!-- Hero Section -->
<div class="hero min-h-[55vh] bg-base-100">
	<div class="hero-content text-center">
		<div class="max-w-3xl">
			<h1 class="text-5xl font-bold mb-8">Welcome to {{ config('app.name') }}</h1>
			<p class="text-xl mb-8 text-base-content/70">
				Create and take AI-powered quizzes on any topic. Perfect for learning, teaching, or just having fun!
			</p>
			<div class="flex flex-col sm:flex-row gap-4 justify-center">
				@auth
					<a href="{{ route('quizzes.create') }}" class="btn btn-primary">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
						Create Quiz
					</a>
					<a href="{{ route('quizzes.index') }}" class="btn btn-outline">
						Browse Quizzes
					</a>
				@else
					<a href="{{ route('register') }}" class="btn btn-primary">
						Get Started
					</a>
					<a href="{{ route('login') }}" class="btn btn-outline">
						Sign In
					</a>
				@endauth
			</div>
		</div>
	</div>
</div>