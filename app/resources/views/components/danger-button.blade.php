<button {{ $attributes->merge(['type' => 'submit', 'class' => 'bg-persian_red-600 hover:bg-persian_red-700 inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-sm text-white focus:outline-none focus:ring-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
