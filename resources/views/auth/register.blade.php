<x-guest-layout>
    <div class="flex items-center justify-center">
        <div class="card w-[30rem] max-w-md bg-base-100 shadow-xl">
            <div class="card-body">
                <!-- Header -->
                <h2 class="card-title text-2xl font-bold text-center justify-center mb-2">Create Account</h2>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="form-control">
                        <label class="label" for="name">
                            <span class="label-text">{{ __('Name') }}</span>
                        </label>
                        <input type="text" 
                               id="name"
                               name="name"
                               value="{{ old('name') }}"
                               class="input input-bordered @error('name') input-error @enderror"
                               required
                               autofocus />
                        @error('name')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="form-control mt-2">
                        <label class="label" for="email">
                            <span class="label-text">{{ __('Email') }}</span>
                        </label>
                        <input type="email" 
                               id="email"
                               name="email"
                               value="{{ old('email') }}"
                               class="input input-bordered @error('email') input-error @enderror"
                               required />
                        @error('email')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-control mt-2">
                        <label class="label" for="password">
                            <span class="label-text">{{ __('Password') }}</span>
                        </label>
                        <input type="password"
                               id="password"
                               name="password"
                               class="input input-bordered @error('password') input-error @enderror"
                               required />
                        @error('password')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-control mt-2">
                        <label class="label" for="password_confirmation">
                            <span class="label-text">{{ __('Confirm Password') }}</span>
                        </label>
                        <input type="password"
                               id="password_confirmation"
                               name="password_confirmation"
                               class="input input-bordered"
                               required />
                    </div>

                    <!-- Actions -->
                    <div class="card-actions mt-6">
                        <div class="flex flex-col sm:flex-row justify-between items-center w-full gap-4">
                            <div class="text-sm">
                                {{ __('Already have an account?') }}
                                <a href="{{ route('login') }}" 
                                   class="link link-primary">
                                    {{ __('Log in') }}
                                </a>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
