<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="relative sm:flex sm:justify-center sm:items-center bg-center selection:text-white">
        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
            <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 hover:underline focus:outline focus:outline-2 focus:rounded-sm">Log in</a>
            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 hover:underline focus:outline focus:outline-2 focus:rounded-sm">Register</a>
        </div>
    </div>

    <form method="POST" action="{{ route('welcome.create-url') }}" class="mb-3">
        @csrf

        <div class="flex items-center justify-center mt-4">
            <div class="flex">
                <div>
                    <x-text-input id="new_url" class="w-70" type="url" name="url" :value="old('url')" placeholder="{{ _('enter a URL and....') }}" autofocus autocomplete="url" />
                    <x-input-error :messages="$errors->get('url')" class="mt-2" />
                </div>
                <div>
                    <x-primary-button class="ml-3" id="create-url-submit-button">
                        {{ __('Make it Little') }}
                    </x-primary-button>
                </div>
            </div>
        </div>
    </form>

    @if (session('littleUrl'))
    <hr class="mt-6 mb-7">
    <div class="pb-3 flex items-center justify-around">
        <div class="flex items-center justify-center gap-2">
            <a class="font-medium" id="new-url-link" href="{{ session('littleUrl') }}">
                {{ session('littleUrl') }}
            </a>
            <button class="copy-to-clipboard">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5A3.375 3.375 0 006.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0015 2.25h-1.5a2.251 2.251 0 00-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 00-9-9z" />
                </svg>
            </button>
        </div>

        <div>
            {!! QrCode::size(80)->generate(session('littleUrl')); !!}
        </div>
    </div>
    @endisset

</x-guest-layout>
