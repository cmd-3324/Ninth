<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
        @csrf

        <!-- Email Address -->
        <div class="mb-6">
            <x-input-label for="UserName" :value="__('UserName')" class="block text-gray-700 font-semibold mb-2" />
            <x-text-input id="UserName" class="block mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" type="text" name="UserName" :value="old('UserName')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('UserName')" class="mt-2 text-red-600 text-sm" />
        </div>

        <!-- Password -->
        <div class="mb-6">
            <x-input-label for="password" :value="__('Password')" class="block text-gray-700 font-semibold mb-2" />
            <x-text-input id="password" class="block mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600 text-sm" />
        </div>

        <!-- Remember Me -->
        <div class="mb-6 flex items-center">
            <input id="remember_me" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" name="remember" />
            <label for="remember_me" class="ml-2 block text-gray-700 text-sm select-none">{{ __('Remember me') }}</label>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-indigo-600 hover:text-indigo-900 text-sm underline">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <p class="text-sm text-gray-700">
                Don’t have an account?
                <a href="{{ url('register') }}" class="text-indigo-600 hover:text-indigo-900 underline">
                    Create An Account
                </a>
            </p>

            <x-primary-button class="px-6 py-2 text-white bg-indigo-600 hover:bg-indigo-700 rounded-md shadow-sm transition">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
