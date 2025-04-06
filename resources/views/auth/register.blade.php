<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 dark:bg-gray-900 px-4">

        <div class="max-w-md w-full bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 space-y-6">

            <h2 class="text-3xl font-extrabold text-center text-gray-800 dark:text-gray-100">
                Create Account ✨
            </h2>
            <p class="text-center text-gray-500 dark:text-gray-400 text-sm">
                Register for your CodeNestIIT account
            </p>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                {{-- Name --}}
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" class="block mt-1 w-full" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                {{-- Email --}}
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" class="block mt-1 w-full" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Password --}}
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" type="password" name="password" required autocomplete="new-password" class="block mt-1 w-full" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- Confirm Password --}}
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="block mt-1 w-full" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                {{-- Role --}}
                <div>
                    <x-input-label for="role" :value="__('Register as')" />
                    <select id="role" name="role" required class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-red-200">
                        <option value="student">Student</option>
                        <option value="teacher">Teacher</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>

                {{-- Register Button --}}
                <div>
                    <x-primary-button class="w-full justify-center bg-red-500 hover:bg-red-600">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>

                {{-- Already Registered --}}
                <p class="text-center text-sm text-gray-600 dark:text-gray-400">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-red-500 hover:underline">
                        Login
                    </a>
                </p>
            </form>
        </div>

        {{-- Background Decoration --}}
        <div class="absolute -top-20 -left-20 w-72 h-72 bg-red-500 opacity-20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-20 -right-20 w-72 h-72 bg-indigo-500 opacity-20 rounded-full blur-3xl animate-pulse"></div>

    </div>
</x-guest-layout>
