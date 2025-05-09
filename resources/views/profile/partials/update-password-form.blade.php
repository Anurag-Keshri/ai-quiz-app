<section>
    <header>
        <h2 class="text-lg font-medium">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="form-control w-full">
            <label class="label" for="update_password_current_password">
                <span class="label-text">{{ __('Current Password') }}</span>
            </label>
            <input 
                id="update_password_current_password" 
                name="current_password" 
                type="password" 
                class="input input-bordered w-full" 
                autocomplete="current-password" 
            />
            @error('current_password', 'updatePassword')
                <label class="label">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </label>
            @enderror
        </div>

        <div class="form-control w-full">
            <label class="label" for="update_password_password">
                <span class="label-text">{{ __('New Password') }}</span>
            </label>
            <input 
                id="update_password_password" 
                name="password" 
                type="password" 
                class="input input-bordered w-full" 
                autocomplete="new-password" 
            />
            @error('password', 'updatePassword')
                <label class="label">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </label>
            @enderror
        </div>

        <div class="form-control w-full">
            <label class="label" for="update_password_password_confirmation">
                <span class="label-text">{{ __('Confirm Password') }}</span>
            </label>
            <input 
                id="update_password_password_confirmation" 
                name="password_confirmation" 
                type="password" 
                class="input input-bordered w-full" 
                autocomplete="new-password" 
            />
            @error('password_confirmation', 'updatePassword')
                <label class="label">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </label>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-success"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
