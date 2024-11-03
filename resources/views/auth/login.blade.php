<x-guest-layout>
        <div class="card w-full max-w-md bg-base-100 shadow-xl">
            <div class="card-body">
                <!-- Header -->
                <h2 class="card-title text-2xl font-bold text-center justify-center mb-2">Login</h2>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="form-control">
                        <label class="label" for="email">
                            <span class="label-text">{{ __('Email') }}</span>
                        </label>
                        <input type="email" 
                               id="email"
                               name="email"
                               value="{{ old('email') }}"
                               class="input input-bordered @error('email') input-error @enderror"
                               required
                               autofocus />
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

                    <!-- Remember Me -->
                    <div class="form-control mt-4">
                        <label class="label cursor-pointer justify-start gap-2">
                            <input type="checkbox" 
                                   name="remember"
                                   class="checkbox checkbox-primary" />
                            <span class="label-text">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <!-- Actions -->
                    <div class="card-actions mt-6">
                        <div class="flex flex-col sm:flex-row justify-between items-center w-full gap-4">
                            <div class="text-sm">
                                {{ __("Don't have an account?") }}
                                <a href="{{ route('register') }}" 
                                   class="link link-primary">
                                    {{ __('Sign up') }}
                                </a>
                            </div>
                            <button type="submit" class="btn btn-primary w-36">
                                {{ __('Log in') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
</x-guest-layout>
