<!-- Quiz Share Modal -->
<dialog id="share_modal" class="modal modal-bottom sm:modal-middle">
	<div class="modal-box"
		 x-data="{
			searchQuery: '',
			quizzes: {{ $authUserQuizzes ? $authUserQuizzes->toJson() : '[]' }},
			copyStatus: {},
			showAlert: false,
			alertMessage: '',
			
			filteredQuizzes() {
				return this.quizzes.filter(quiz => 
					quiz.title.toLowerCase().includes(this.searchQuery.toLowerCase())
				);
			},
			
			async copyToClipboard(text, quizId, type = 'link') {
				await navigator.clipboard.writeText(text);
				this.copyStatus[quizId] = true;
				this.showAlert = true;
				this.alertMessage = type === 'link' ? 'Share link copied to clipboard!' : 'Access code copied to clipboard!';
				
				setTimeout(() => {
					this.copyStatus[quizId] = false;
				}, 2000);
				
				setTimeout(() => {
					this.showAlert = false;
				}, 3000);
			}
		 }">
		
		<h3 class="font-bold text-lg mb-4">Share Your Quizzes</h3>
		
		<!-- Alert Notification -->
		<div class="relative">
			<div class="absolute top-0 left-0 right-0 z-50"
				 x-show="showAlert"
				 x-transition:leave="transition ease-in duration-200">
				<div class="alert alert-success shadow-lg">
					<svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
					</svg>
					<span x-text="alertMessage"></span>
				</div>
			</div>
		</div>
		
		<template x-if="quizzes.length > 0">
			<div class="space-y-4">
				<!-- Search Input -->
				<div class="form-control">
					<input type="text" 
						   placeholder="Search quizzes..." 
						   class="input input-bordered w-full"
						   x-model="searchQuery" />
				</div>

				<!-- Quiz Table -->
				<div class="overflow-x-auto">
					<table class="table table-zebra">
						<thead>
							<tr>
								<th>Quiz Title</th>
								<th>Access Code</th>
								<th>Created</th>
								<th>Share</th>
							</tr>
						</thead>
						<tbody>
							<template x-for="quiz in filteredQuizzes()" :key="quiz.id">
								<tr>
									<td x-text="quiz.title"></td>
									<td>
										<div class="flex items-center gap-2">
											<code class="bg-base-200 px-2 py-1 rounded" x-text="quiz.id"></code>
											<button class="btn btn-ghost btn-xs"
													@click="copyToClipboard(quiz.id, `code-${quiz.id}`, 'code')">
												<template x-if="!copyStatus[`code-${quiz.id}`]">
													<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
														<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-2M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
													</svg>
												</template>
												<template x-if="copyStatus[`code-${quiz.id}`]">
													<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor">
														<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
													</svg>
												</template>
											</button>
										</div>
									</td>
									<td x-text="new Date(quiz.created_at).toLocaleDateString()"></td>
									<td>
										<button class="btn btn-ghost btn-sm"
												@click="copyToClipboard(`${window.location.origin}/quizzes/${quiz.id}/attempts/create`, `link-${quiz.id}`, 'link')">
											<template x-if="!copyStatus[`link-${quiz.id}`]">
												<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
												</svg>
											</template>
											<template x-if="copyStatus[`link-${quiz.id}`]">
												<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
												</svg>
											</template>
										</button>
									</td>
								</tr>
							</template>
						</tbody>
					</table>
				</div>
			</div>
		</template>

		<template x-if="quizzes.length === 0">
			<div class="text-center py-8">
				<div class="mb-4">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-base-content/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
					</svg>
				</div>
				<h3 class="font-medium mb-2">No Quizzes Yet</h3>
				<p class="text-base-content/70 mb-4">Create your first quiz to start sharing!</p>
				<a href="{{ route('quizzes.create') }}" class="btn btn-primary">
					Create Quiz
				</a>
			</div>
		</template>

		<div class="modal-action">
			<form method="dialog">
				<button class="btn">Close</button>
			</form>
		</div>
	</div>
	<form method="dialog" class="modal-backdrop">
		<button>close</button>
	</form>
</dialog>
