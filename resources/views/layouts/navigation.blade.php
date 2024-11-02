<div class="navbar bg-base-100 border-b border-base-200">
    <div class="navbar-start">
        <!-- Mobile Menu Button -->
        <div class="lg:hidden">
            <label for="nav-drawer" class="btn btn-square btn-ghost drawer-button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-5 h-5 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </label>
        </div>

        <!-- Logo -->
        <a href="{{ route('landing') }}" class="btn btn-ghost normal-case text-xl gap-2">
            <x-application-logo class="h-6 w-auto" />
            {{ config('app.name') }}
        </a>
    </div>

    <!-- Desktop Navigation -->
    <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal px-1 gap-2">
            <li>
                <a href="{{ route('landing') }}" class="{{ request()->routeIs('landing') ? 'active' : '' }}">
                    Home
                </a>
            </li>
            @auth
                <li>
                    <a href="{{ route('quizzes.index') }}" class="{{ request()->routeIs('quizzes.*') ? 'active' : '' }}">
                        My Quizzes
                    </a>
                </li>
                <li>
                    <a href="{{ route('attempts.index') }}" class="{{ request()->routeIs('attempts.*') ? 'active' : '' }}">
                        My Attempts
                    </a>
                </li>
            @endauth
        </ul>
    </div>

    <!-- Right Side Navigation -->
    <div class="navbar-end">
        @auth
            <div class="dropdown dropdown-end">
                <!-- Dropdown Toggle Button -->
                <label tabindex="0" class="btn btn-ghost m-1">
                    <div class="flex items-center gap-2">
                        <div class="avatar placeholder">
                            <div class="bg-neutral text-neutral-content rounded-full w-8">
                                <span class="text-sm">{{ substr(auth()->user()->name, 0, 2) }}</span>
                            </div>
                        </div>
                        <span class="hidden sm:inline-block">{{ Auth::user()->name }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </label>

                <!-- Dropdown Menu -->
                <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                    <li>
                        <a href="{{ route('profile.edit') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                            </svg>
                            Profile
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('quizzes.index') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                            </svg>
                            My Quizzes
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('attempts.index') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            My Attempts
                        </a>
                    </li>
                    <div class="divider my-1"></div>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="w-full text-left text-error">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                                </svg>
                                Log Out
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        @else
            <div class="flex gap-2">
                <a href="{{ route('login') }}" class="btn btn-ghost">Log In</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Sign Up</a>
            </div>
        @endauth
    </div>
</div>

<!-- Mobile Drawer -->
<div class="drawer">
    <input id="nav-drawer" type="checkbox" class="drawer-toggle" />
    
    <div class="drawer-side z-50">
        <label for="nav-drawer" class="drawer-overlay"></label>
        <ul class="menu p-4 w-80 min-h-full bg-base-200">
            <!-- App Name -->
            <div class="flex items-center gap-2 px-4 pb-4 mb-4 border-b border-base-300">
                <x-application-logo class="h-6 w-auto" />
                <span class="text-xl font-bold">{{ config('app.name') }}</span>
            </div>

            <!-- Navigation Links -->
            <li>
                <a href="{{ route('landing') }}" class="{{ request()->routeIs('landing') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                    </svg>
                    Home
                </a>
            </li>

            @auth
                <li>
                    <a href="{{ route('quizzes.index') }}" class="{{ request()->routeIs('quizzes.*') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                        </svg>
                        My Quizzes
                    </a>
                </li>
                <li>
                    <a href="{{ route('attempts.index') }}" class="{{ request()->routeIs('attempts.*') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        My Attempts
                    </a>
                </li>

                <div class="divider">Account</div>

                <li>
                    <a href="{{ route('profile.edit') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                        </svg>
                        Profile
                    </a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full text-left text-error">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                            </svg>
                            Log Out
                        </button>
                    </form>
                </li>
            @else
                <li>
                    <a href="{{ route('login') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Log In
                    </a>
                </li>
                <li>
                    <a href="{{ route('register') }}" class="text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                        </svg>
                        Sign Up
                    </a>
                </li>
            @endauth
        </ul>
    </div>
</div>