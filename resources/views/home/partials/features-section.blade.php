<!-- Features Section -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
	<!-- Create Card -->
	<div class="card bg-base-100 shadow-xl border border-base-300">
		<div class="card-body items-center text-center">
			<a href="{{ route('quizzes.create') }}" class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-4 cursor-pointer hover:bg-primary/20 transition-colors">
				<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
			</a>
			<h2 class="card-title text-2xl mb-2">Create</h2>
			<p class="text-base-content/70">
				Generate custom quizzes powered by AI. Just provide a topic and AI will generate a quiz for you.
			</p>
		</div>
	</div>

	<!-- Attempt Card -->
	<div class="card bg-base-100 shadow-xl border border-base-300">
		<div class="card-body items-center text-center">
			<div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-4 cursor-pointer hover:bg-primary/20 transition-colors"
					onclick="quick_attempt_modal.showModal()">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-scroll-text"><path d="M15 12h-5"/><path d="M15 8h-5"/><path d="M19 17V5a2 2 0 0 0-2-2H4"/><path d="M8 21h12a2 2 0 0 0 2-2v-1a1 1 0 0 0-1-1H11a1 1 0 0 0-1 1v1a2 2 0 1 1-4 0V5a2 2 0 1 0-4 0v2a1 1 0 0 0 1 1h3"/></svg>
			</div>
			<h2 class="card-title text-2xl mb-2">Attempt</h2>
			<p class="text-base-content/70">
				Challenge yourself with quizzes on various topics. Track your progress and improve your knowledge.
			</p>
		</div>
	</div>

	<!-- Share Card -->
	<div class="card bg-base-100 shadow-xl border border-base-300">
		<div class="card-body items-center text-center">
			<div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-4 cursor-pointer hover:bg-primary/20 transition-colors"
					onclick="share_modal.showModal()">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-share-2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"/><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"/></svg>
			</div>
			<h2 class="card-title text-2xl mb-2">Share</h2>
			<p class="text-base-content/70">
				Share your quizzes with others and see how they perform. Perfect for teachers and study groups.
			</p>
		</div>
	</div>
</div>

@include('home.partials.quiz-attempt-modal')

@include('home.partials.quiz-share-modal')
