@props(['title' => 'Cancel'])
<i {{ $attributes->merge(['class' => 'fas fa-times mr-1', 'role' => 'button']) }} title="{{ $title }}"></i>