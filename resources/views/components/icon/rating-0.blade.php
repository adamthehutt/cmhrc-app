@props(['rating'])
<button
    href="#"
    aria-label="{{ __('ratings.0') }}"
    @class([
        'text-4xl',
        'opacity-25' => $rating !== 0,
        'hover:opacity-100' => $rating !== 0,
        'opacity-100' => $rating === 0
    ])
    @click.prevent="$dispatch('input', 0)"
>
    <img src="{{ asset("/images/ratings/0.png") }}" alt="{{ __("ratings.0") }}"/>
</button>