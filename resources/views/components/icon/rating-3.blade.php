@props(['rating'])
<button
    href="#"
    aria-label="{{ __('ratings.3') }}"
    @class([
        'text-4xl',
        'opacity-25' => $rating !== 3,
        'hover:opacity-100' => $rating !== 3,
        'opacity-100' => $rating === 3
    ])
    @click.prevent="$dispatch('input', 3)"
>
    <img src="{{ asset("/images/ratings/3.png") }}" alt="{{ __("ratings.3") }}"/>
</button>