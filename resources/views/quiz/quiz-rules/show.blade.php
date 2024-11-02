@extends('layouts.app')

@section('content')
<div class="min-h-[calc(100vh-73px)] bg-base-200 py-4">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto space-y-6">
			<!-- Header Section -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Quiz Rules</h1>
                @can('update', $quizRules->quiz)
                    <a href="{{ route('quiz_rules.edit', $quizRules) }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                        Edit Rules
                    </a>
					@endcan
				</div>
				
			<!-- Time & Date Availability Card -->
			<div class="card bg-base-100 shadow-xl border border-base-300">
				<div class="card-body">
					<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Time Limit -->
                        <div class="flex gap-2">
                            <div class="flex items-center gap-3">
								<div class="p-3 bg-primary/10 rounded-lg">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-timer"><line x1="10" x2="14" y1="2" y2="2"/><line x1="12" x2="15" y1="14" y2="11"/><circle cx="12" cy="14" r="8"/></svg>
								</div>
								<div>
									<div class="font-medium mb-1">Time Limit</div>
									@if($quizRules->time_limit)
										<div class="badge badge-primary badge-lg">{{ $quizRules->time_limit }} minutes</div>
									@else
										<div class="badge badge-ghost badge-lg">No time limit</div>
									@endif
								</div>
							</div>
                        </div>

						<!-- Start Date -->
						<div class="flex items-center gap-4">
							<div class="p-3 bg-primary/10 rounded-lg">
								<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8"	 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>
							</div>
							<div>
								<div class="font-medium mb-1">Start Date</div>
								@if($quizRules->start_date)
									<div class="text-lg">{{ $quizRules->start_date->format('M d, Y') }}</div>
									<div class="text-sm text-base-content/70">{{ $quizRules->start_date->format('h:i A') }}</div>
								@else
									<div class="text-base-content/70">No start date set</div>
								@endif
							</div>
						</div>

						<!-- End Date -->
						<div class="flex items-center gap-4">
							<div class="p-3 bg-primary/10 rounded-lg">
								<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8"	 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>
							</div>	
							<div>
								<div class="font-medium mb-1">End Date</div>
								@if($quizRules->end_date)
									<div class="text-lg">{{ $quizRules->end_date->format('M d, Y') }}</div>
									<div class="text-sm text-base-content/70">{{ $quizRules->end_date->format('h:i A') }}</div>
								@else
									<div class="text-base-content/70">No end date set</div>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>

            <!-- Quiz Settings Card -->
            <div class="card bg-base-100 shadow-xl border border-base-300">
                <div class="card-body">
                    <h2 class="card-title text-xl mb-6">Quiz Settings</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach([
                            'show_score' => ['Show Score', 'Show score after submission', 'Users can see their final score immediately after completing the quiz'],
                            'shuffle_options' => ['Shuffle Options', 'Randomize answer order', 'Answer options are presented in a random order for each attempt'],
                            'shuffle_questions' => ['Shuffle Questions', 'Randomize question order', 'Questions appear in a different order for each attempt'],
                            'show_correct_answer' => ['Show Answers', 'Show correct answers', 'Display correct answers after quiz completion']
                        ] as $key => $details)
                            <div class="card bg-base-200">
                                <div class="card-body p-6">
                                    <div class="flex items-center gap-4 mb-2">
                                        @if($quizRules->$key)
                                            <div class="badge badge-success">Enabled</div>
                                        @else
                                            <div class="badge badge-error">Disabled</div>
                                        @endif
                                        <h3 class="font-medium">{{ $details[0] }}</h3>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection