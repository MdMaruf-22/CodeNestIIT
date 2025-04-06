<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 dark:bg-gray-900 px-4">

        <div class="max-w-md w-full bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 space-y-6">

            <h2 class="text-3xl font-extrabold text-center text-gray-800 dark:text-gray-100">
                Welcome Back 👋
            </h2>
            <p class="text-center text-gray-500 dark:text-gray-400 text-sm">
                Login to your CodeNestIIT account
            </p>

            {{-- Session Status --}}
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" class="block mt-1 w-full" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Password --}}
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" type="password" name="password" required autocomplete="current-password" class="block mt-1 w-full" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 dark:border-gray-700 text-red-500 shadow-sm focus:ring-red-500 dark:focus:ring-red-600 dark:focus:ring-offset-gray-800" name="remember">
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-red-500 hover:underline" href="{{ route('password.request') }}">
                            Forgot Password?
                        </a>
                    @endif
                </div>

                {{-- Login Button --}}
                <div>
                    <x-primary-button class="w-full justify-center bg-red-500 hover:bg-red-600">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>

                {{-- Register Option --}}
                @if (Route::has('register'))
                <p class="text-center text-sm text-gray-600 dark:text-gray-400">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-red-500 hover:underline">
                        Register
                    </a>
                </p>
                @endif
            </form>
        </div>

        {{-- Background Decoration --}}
        <div class="absolute -top-20 -left-20 w-72 h-72 bg-red-500 opacity-20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-20 -right-20 w-72 h-72 bg-indigo-500 opacity-20 rounded-full blur-3xl animate-pulse"></div>

    </div>
</x-guest-layout>

