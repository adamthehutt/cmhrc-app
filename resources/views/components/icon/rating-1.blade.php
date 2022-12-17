@props(['rating'])
<button
    href="#"
    aria-label="{{ __('ratings.1') }}"
    @class([
        'text-4xl',
        'opacity-25' => $rating !== 1,
        'hover:opacity-100' => $rating !== 1,
        'opacity-100' => $rating === 1
    ])
    @click.prevent="$dispatch('input', 1)"
>
    <img src="{{ asset("/images/ratings/1.png") }}" alt="{{ __("ratings.1") }}"/>
</button>