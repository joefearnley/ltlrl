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
                <div class="py-6 px-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex justify-between items-center">
                        <div class=" text-gray-900">
                            <h3 class="text-2xl font-extrabold pb-6">
                                {{ $url->title }}
                            </h3>
                            <p class="py-1">
                                <a class="text-md text-blue-900" href="{{ $url->little_url }}">
                                    {{ $url->little_url }}
                                </a>
                            </p>
                            <p class="py-1">
                                <a class="text-md text-gray-500" href="{{ $url->url }}">
                                    {{ $url->url }}
                                </a>
                            </p>
                        </div>
                        <div>
                            <a href="{{ route('urls.update', $url) }}" class="block mt-4 mb-4 text-white bg-dark_slate_gray-700 hover:bg-dark_slate_gray-800 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                                Edit
                            </a>
                            <a href="{{ route('urls.destroy', $url) }}" class="block mt-4 mb-4 text-white bg-persian_red-700 hover:bg-persian_red-800 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                                Delete
                            </a>
                        </div>
                    </div>
                    <hr class="block mt-4 mb-4">
                    <p>{{ $url->created_at->format('M j, Y') }}</p>
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
