<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button 
        class="btn btn-error"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</button>

    <dialog id="confirm-user-deletion" class="modal modal-bottom sm:modal-middle" :open="$errors->userDeletion->isNotEmpty()">
        <div class="modal-box">
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <h3 class="font-bold text-lg">
                    {{ __('Are you sure you want to delete your account?') }}
                </h3>

                <p class="py-4 text-sm">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>

                <div class="form-control w-full">
                    <label class="label sr-only" for="password">
                        <span class="label-text">{{ __('Password') }}</span>
                    </label>

                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="input input-bordered w-full"
                        placeholder="{{ __('Password') }}"
                    />

                    @error('password', 'userDeletion')
                        <div class="text-error text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="modal-action">
                    <button type="button" class="btn" x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </button>

                    <button type="submit" class="btn btn-error">
                        {{ __('Delete Account') }}
                    </button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
</section>
