<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Little Urls') }}
        </h2>
    </x-slot>

    @if (session()->has('message'))
    <div class="row justify-content-center mt-4 align-self-center">
        <div class="col-md-8 mt-4">
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ session()->get('message') }}</strong>
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
                            <p class="py-1">
                                <a class="text-md text-gray-900" href="{{ $url->little_url }}">
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
                            <a href="{{ route('urls.edit', $url) }}" class="block mt-4 mb-4 text-white bg-dark_slate_gray-700 hover:bg-dark_slate_gray-800 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                                {{ __('Edit') }}
                            </a>
                            <x-danger-button
                                class="bg-persian_red-700 hover:bg-persian_red-800"
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
