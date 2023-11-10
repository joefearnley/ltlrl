@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:outline-none focus:bg-white focus:border-gray-500 rounded-md shadow-sm']) !!}>
