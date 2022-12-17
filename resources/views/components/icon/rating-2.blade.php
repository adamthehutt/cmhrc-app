@props(['rating'])
<button
    href="#"
    aria-label="{{ __('ratings.2') }}"
    @class([
        'text-4xl',
        'opacity-25' => $rating !== 2,
        'hover:opacity-100' => $rating !== 2,
        'opacity-100' => $rating === 2
    ])
    @click.prevent="$dispatch('input', 2)"
>
    <img src="{{ asset("/images/ratings/2.png") }}" alt="{{ __("ratings.2") }}"/>
</button>