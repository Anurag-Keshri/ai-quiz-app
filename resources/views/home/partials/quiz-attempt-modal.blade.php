<!-- Quick Attempt Modal -->
<dialog id="quick_attempt_modal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Quick Quiz Access</h3>
        <form x-data="{ quiz_id: null }" x-on:submit.prevent="window.location.href = `/quizzes/${quiz_id}/attempts/create`" method="GET" id="quickAttemptForm" class="space-y-4">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Enter Quiz ID</span>
                </label>
                <input 
					type="number" 
					x-model="quiz_id"
					id="quiz_id" 
					class="input input-bordered w-full" 
					placeholder="Enter quiz ID"
					min="1"
					required 
				/>
            </div>
            <div class="modal-action">
                <button type="button" 
                        class="btn btn-ghost"
                        onclick="quick_attempt_modal.close()">Cancel</button>
                <button type="submit" 
                        class="btn btn-primary">
                    Start Quiz
                </button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>