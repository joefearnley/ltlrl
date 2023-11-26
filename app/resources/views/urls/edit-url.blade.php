<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Url') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Update Url') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Make any changes and click Save.') }}
                            </p>
                        </header>

                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <form method="post" action="{{ route('urls.store') }}" class="mt-6 space-y-6">
                            @csrf

                            <div>
                                <x-input-label for="title" :value="__('Title')" />
                                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="$url->title" autofocus autocomplete="title" />
                                <x-input-error class="mt-2" :messages="$errors->get('title')" />
                            </div>

                            <div>
                                <x-input-label for="url" :value="__('URL')" />
                                <x-text-input id="url" name="url" type="url" class="mt-1 block w-full" :value="$url->title" required autocomplete="url" />
                                <x-input-error class="mt-2" :messages="$errors->get('url')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button class="bg-dark_slate_gray-700 hover:bg-dark_slate_gray-800 focus:bg-dark_slate_gray-800 active:bg-dark_slate_gray-800">{{ __('Save') }}</x-primary-button>
                                <x-link-button :href="route('urls.index')" class="">{{ __('Cancel') }}</x-link-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
