<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="relative w-96 mx-auto p-8">
        @csrf

        <!-- Login Title -->
        <h2 class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-xl font-bold">
            {{ __('LOGIN') }}</h2>

        <!-- Email Address -->
        <div class="mt-6">
            <label for="email" class="block text-gray-700">{{ __('Email Address') }}<span
                    class="text-red-600">*</span></label>
            <input id="email" class="block mt-1 w-full bg-gray-200 p-2" type="email" name="email"
                :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="block text-gray-700">{{ __('Password') }}<span
                    class="text-red-600">*</span></label>
            <div class="relative">
                <input id="password" class="block mt-1 w-full bg-gray-200 p-2" type="password" name="password" required
                    autocomplete="current-password" />
                <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer"
                    onclick="togglePassword()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path
                            d="M10 3C5 3 1.74 7.11.55 9.26a1 1 0 000 .92C1.74 12.89 5 17 10 17s8.26-4.11 9.45-6.26a1 1 0 000-.92C18.26 7.11 15 3 10 3zm0 12a5 5 0 110-10 5 5 0 010 10zm0-8a3 3 0 100 6 3 3 0 000-6z" />
                    </svg>
                </span>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-center mt-6">
            <button type="submit" class="px-4 py-2 border border-black text-black font-semibold">
                {{ __('LOG IN') }}
            </button>
        </div>

        <!-- Register Link -->
        <div class="flex items-center justify-center mt-4">
            <a href="{{ route('register') }}" class="underline text-sm text-gray-600 hover:text-gray-900">
                {{ __('Don\'t have an account? Register here') }}
            </a>
        </div>
    </form>
</x-guest-layout>

<script>
    function togglePassword() {
        const passwordField = document.getElementById('password');
        const type = passwordField.type === 'password' ? 'text' : 'password';
        passwordField.type = type;
    }
</script>
