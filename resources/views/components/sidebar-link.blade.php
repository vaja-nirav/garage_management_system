@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center px-2 py-2 text-sm font-medium text-white bg-gray-800 rounded-md group transition-colors duration-150'
            : 'flex items-center px-2 py-2 text-sm font-medium text-gray-300 rounded-md hover:text-white hover:bg-gray-800 group transition-colors duration-150';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <span class="mr-3">
        {{ $slot }}
    </span>
</a>
