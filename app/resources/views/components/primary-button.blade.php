<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-dark_slate_gray-700 border border-transparent rounded-md font-semibold text-sm text-white tracking-widest hover:bg-dark_slate_gray-800 focus:bg-dark_slate_gray-800 active:bg-dark_slate_gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
