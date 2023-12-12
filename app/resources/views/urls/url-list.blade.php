<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Little Urls') }}
        </h2>
    </x-slot>

    @if (session()->has('message'))
    <div x-data="{ open: true }">
        <div class="pt-6 pb-3" x-show="open">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="rounded-lg bg-dark_slate_gray-700 px-6 py-5 text-base text-white flex justify-between" role="alert">
                    <div>{{ session()->get('message') }} - {{ session()->get('urlTitle') }} ({{ session()->get('littleUrl') }})</div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 cursor-pointer" x-on:click="open = false">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if ($urls->count() > 0)
        @foreach ($urls as $url)
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="py-6 px-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex justify-between items-center">
                        <div class=" text-gray-900">
                            <h3 class="text-2xl font-extrabold pb-6">
                                {{ $url->title }}
                            </h3>
                            <p class="py-1 flex gap-2">
                                <a class="text-md text-gray-900" href="{{ $url->little_url }}">
                                    {{ $url->little_url }}
                                </a>
                                <button class="copy-to-clipboard text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 cursor-pointer">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5A3.375 3.375 0 006.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0015 2.25h-1.5a2.251 2.251 0 00-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 00-9-9z" />
                                    </svg>
                                </button>
                            </p>
                            <p class="py-1">
                                <a class="text-md text-gray-500" href="{{ $url->url }}">
                                    {{ $url->url }}
                                </a>
                            </p>
                        </div>
                        <div class="flex gap-8 align-middle justify-center items-center">
                            <div>
                                {!! QrCode::size(80)->generate($url->little_url); !!}
                            </div>
                            <div class="flex flex-col gap-2">
                                <a href="{{ route('urls.edit', $url) }}" class=" text-white bg-dark_slate_gray-700 hover:bg-dark_slate_gray-800 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                                    {{ __('Edit') }}
                                </a>
                                <x-danger-button
                                    x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'confirm={{ $url->id }}-url-deletion')">
                                    {{ __('Delete') }}
                                </x-danger-button>
                                <x-modal name="confirm={{ $url->id }}-url-deletion" :show="false" focusable>
                                    <form method="post" action="{{ route('urls.destroy', $url) }}" class="p-6">
                                        @csrf
                                        @method('delete')

                                        <h2 class="text-lg font-medium text-gray-900">
                                            {{ __('Are you sure you want to delete this Url?') }}
                                        </h2>

                                        <div class="mt-6 flex justify-end">
                                            <x-secondary-button x-on:click="$dispatch('close')">
                                                {{ __('Cancel') }}
                                            </x-secondary-button>

                                            <x-danger-button class="ml-3">
                                                {{ __('Delete Url') }}
                                            </x-danger-button>
                                        </div>
                                    </form>
                                </x-modal>
                            </div>
                        </div>
                    </div>
                    <hr class="block mt-4 mb-4">
                    <div class="flex gap-2">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                        </div>
                        <div>{{ $url->created_at->format('M j, Y g:i:s a') }}</div>
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    @else
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl text-bold py-3">{{ __('No Urls Made Little Yet.')}}</h3>
                    <p class="mt-4">
                        <a href="{{ route('urls.create') }}" class="text-white bg-dark_slate_gray-700 hover:bg-dark_slate_gray-800 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                            Create One
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endif

</x-app-layout>
