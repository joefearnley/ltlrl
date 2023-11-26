@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:outline-none focus:ring-0 focus:bg-white focus:border-gray-500 rounded-md shadow-sm']) !!}>
