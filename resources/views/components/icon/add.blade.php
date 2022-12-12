@props(['title' => 'Add'])
<i {{ $attributes->merge(['class' => 'fas fa-plus-circle mr-1']) }} title="{{ $title }}"></i>