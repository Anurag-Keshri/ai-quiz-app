<dialog id="share_quiz_{{ $quiz->id }}" class="modal modal-bottom sm:modal-middle">
	<div class="modal-box"
		 x-data="{
			copyStatus: {},
			showAlert: false,
			alertMessage: '',
			
			async copyToClipboard(text, type) {
				await navigator.clipboard.writeText(text);
				this.copyStatus[type] = true;
				this.showAlert = true;
				this.alertMessage = type === 'link' ? 'Share link copied!' : 'Access code copied!';
				
				setTimeout(() => {
					this.copyStatus[type] = false;
				}, 2000);
				
				setTimeout(() => {
					this.showAlert = false;
				}, 3000);
			}
		}">
		
		<div class="flex justify-between items-center">
			<h3 class="font-bold text-lg">Share Quiz: {{ $quiz->title }}</h3>
			<div class="modal-action mt-0">
				<form method="dialog">
					<button class="btn">Close</button>
				</form>
			</div>
		</div>

		<!-- Alert Notification -->
		<div class="relative">
			<div class="absolute top-0 left-0 right-0"
				 x-show="showAlert">
				<div class="alert alert-success shadow-lg">
					<svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
					</svg>
					<span x-text="alertMessage"></span>
				</div>
			</div>
		</div>
		


		<div class="space-y-6 mt-4">
			<!-- Public Link -->
			<div>
				<label class="label">
					<span class="label-text font-medium">Public Link</span>
				</label>
				<div class="join w-full">
					<input type="text" 
						   class="join-item input input-bordered w-full"
						   value="{{ route('attempts.create', $quiz) }}" 
						   readonly />
					<button class="btn join-item"
							@click="copyToClipboard('{{ route('attempts.create', $quiz) }}', 'link')">
						<template x-if="!copyStatus.link">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-2M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
							</svg>
						</template>
						<template x-if="copyStatus.link">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
							</svg>
						</template>
					</button>
				</div>
			</div>

			<!-- Access Code -->
			<div>
				<label class="label">
					<span class="label-text font-medium">Access Code</span>
				</label>
				<div class="join w-full">
					<input type="text" 
						   class="join-item input input-bordered w-full font-mono"
						   value="{{ $quiz->id }}" 
						   readonly />
					<button class="btn join-item"
							@click="copyToClipboard('{{ $quiz->id }}', 'code')">
						<template x-if="!copyStatus.code">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-2M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
							</svg>
						</template>
						<template x-if="copyStatus.code">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
							</svg>
						</template>
					</button>
				</div>
			</div>
		</div>

	</div>
	<form method="dialog" class="modal-backdrop">
		<button>close</button>
	</form>
</dialog>