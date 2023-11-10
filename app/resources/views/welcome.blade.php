<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="relative sm:flex sm:justify-center sm:items-center bg-center selection:text-white">
        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
            <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 hover:underline focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>
            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 hover:underline focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
        </div>
    </div>

    <h1 class="my-3 text-6xl font-bold text-center">ltlrl</h1>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="flex items-center justify-center mt-4">
            <x-text-input id="url" class="mt-1 w-70" type="url" name="url" :value="old('url')" placeholder="{{ _('enter an URL and....') }}" required autofocus autocomplete="url" />
            <x-input-error :messages="$errors->get('url')" class="mt-2" />

            <x-primary-button class="ml-3">
                {{ __('Make Url Little') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
