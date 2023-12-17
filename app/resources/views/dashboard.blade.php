<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto flex">
            <div class="sm:px-6 lg:px-8 basis-1/2">
                <div class="py-6 px-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <h2 class="mb-3 text-2xl font-medium text-gray-900">
                        {{ __('Latest Urls') }}
                    </h2>
                    <hr class="pb-6">
                @if ($recentUrls->count() > 0)
                    @php
                        $count = 1;
                    @endphp
                    @foreach ($recentUrls as $index => $recentUrl)
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-extrabold pb-1">
                                    {{ $recentUrl->title }}
                                </h3>
                                <div class="flex">
                                    <a class="text-sm flex" href="{{ $recentUrl->little_url }}">
                                        <span class="mr-2">{{ $recentUrl->little_url }}</span>
                                    </a>
                                    <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 cursor-pointer">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5A3.375 3.375 0 006.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0015 2.25h-1.5a2.251 2.251 0 00-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 00-9-9z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <div class="mb-1">{{ $recentUrl->created_at->format('M d, Y') }}</div>
                                <div class="flex gap-2">
                                    <a href="{{ route('urls.edit', $recentUrl) }}" class="block text-white bg-dark_slate_gray-700 hover:bg-dark_slate_gray-800 font-medium rounded-lg text-sm p-2.5 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </a>
                                    <x-danger-button
                                        x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'confirm={{ $recentUrl->id }}-url-deletion')">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </x-danger-button>
                                </div>
                                <x-modal name="confirm={{ $recentUrl->id }}-url-deletion" :show="false" focusable>
                                    <form method="post" action="{{ route('urls.destroy', $recentUrl) }}" class="p-6">
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
                        <a class="text-sm text-gray-500" href="{{ $recentUrl->url }}">
                            {{ $recentUrl->url }}
                        </a>
                        @if ($recentUrls->count() > $count)
                        <hr class="block my-3">
                        @endif

                        @php
                            $count++;
                        @endphp
                    @endforeach
                @else
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg text-bold py-3">{{ __('No Urls Made Little Yet.')}}</h3>
                        <p class="mt-4">
                            <a href="{{ route('urls.create') }}" class="text-white bg-dark_slate_gray-700 hover:bg-dark_slate_gray-800 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                                {{ __('Create One') }}
                            </a>
                        </p>
                    </div>
                @endif
                </div>
            </div>
            <div class="sm:px-6 lg:px-8 basis-1/2">
                <div class="py-6 px-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <h2 class="mb-3 text-2xl font-medium">
                        {{ __('Latest Activity') }}
                    </h2>
                    <hr class="pb-6">
                @if ($latestClicks->count() > 0)
                    @php
                        $count = 1;
                    @endphp
                    @foreach ($latestClicks as $click)
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-extrabold pb-1">
                                    {{ $click->url->title }}
                                </h3>
                                <div class="flex">
                                    <a class="text-sm flex" href="{{ $click->url->little_url }}">
                                        <span class="mr-2">{{ $click->url->little_url }}</span>
                                    </a>
                                    <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 cursor-pointer">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5A3.375 3.375 0 006.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0015 2.25h-1.5a2.251 2.251 0 00-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 00-9-9z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <div class="mb-1">{{ date('M d, Y', strtotime($click->click_created_at)) }}</div>
                            </div>
                        </div>
                        <a class="text-sm text-gray-500" href="{{ $click->url->url }}">
                            {{ $click->url->url }}
                        </a>
                        @if ($latestClicks->count() > $count)
                        <hr class="block my-3">
                        @endif

                        @php
                            $count++;
                        @endphp
                    @endforeach
                @else
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg text-bold py-3">{{ __('No Activity Yet!')}}</h3>
                        <p class="mt-4">{{ __('Click on the Create Url link to get started.') }}</p>
                    </div>
                @endif
                </div>
            </div>
        </div>
    </div>

    <div class="py-6">
        <div class="max-w-7xl mx-auto flex">
            <div class="sm:px-6 lg:px-8 basis-1/2">
                <div class="py-6 px-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <h2 class="mb-3 text-2xl font-medium text-gray-900">
                        {{ __('Most Active Urls') }}
                    </h2>
                    <hr class="pb-6">

                    @if ($mostActiveUrls->count() > 0)
                        @php
                            $count = 1;
                        @endphp
                        @foreach ($mostActiveUrls as $mostActiveUrl)
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="text-lg font-extrabold pb-1">
                                        {{ $mostActiveUrl->title }}
                                    </h3>
                                    <div class="flex">
                                        <a class="text-sm flex" href="{{ $mostActiveUrl->little_url }}">
                                            <span class="mr-2">{{ $mostActiveUrl->little_url }}</span>
                                        </a>
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 cursor-pointer">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5A3.375 3.375 0 006.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0015 2.25h-1.5a2.251 2.251 0 00-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 00-9-9z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <div class="mb-1">{{ $mostActiveUrl->created_at->format('M d, Y') }}</div>
                                    <div class="mb-1 font-semibold">
                                    @if ($mostActiveUrl->clicks->count() === 1)
                                        {{ $mostActiveUrl->clicks->count() }} Click
                                    @else
                                        {{ $mostActiveUrl->clicks->count() }} Clicks
                                    @endif
                                    </div>
                                </div>
                            </div>
                            <a class="text-sm text-gray-500" href="{{ $mostActiveUrl->url }}">
                                {{ $mostActiveUrl->url }}
                            </a>
                            @if ($mostActiveUrls->count() > $count )
                            <hr class="block my-3">
                            @endif

                            @php
                                $count++;
                            @endphp
                        @endforeach
                    @else
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg text-bold py-3">{{ __('No Active Urls Yet!')}}</h3>
                            <p class="mt-4">{{ __('Click on the Create Url link to get started.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
