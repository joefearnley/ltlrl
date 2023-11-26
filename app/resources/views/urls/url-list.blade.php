<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Little Urls') }}
        </h2>
    </x-slot>

    @if ($urls->count() > 0)
        @foreach ($urls as $url)
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <p>{{ $url->title }}</p>
                        <p>{{ $url->little_url }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @else
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p>{{ __('No Urls Made Little Yet.')}}</p>
                    <p><a href="{{ route('urls.create') }}">Create One</a></p>
                </div>
            </div>
        </div>
    </div>
    @endif

</x-app-layout>
