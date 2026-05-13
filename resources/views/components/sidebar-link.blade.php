@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center px-4 py-3 text-sm font-semibold text-white bg-indigo-500 rounded-xl shadow-lg shadow-indigo-500/20 group transition-all duration-200 translate-x-1'
            : 'flex items-center px-4 py-3 text-sm font-medium text-slate-400 rounded-xl hover:text-white hover:bg-white/5 group transition-all duration-200 hover:translate-x-1';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
