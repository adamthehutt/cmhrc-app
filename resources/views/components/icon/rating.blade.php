@props(['rating', 'value', 'editable' => true])
<button
    href="#"
    aria-label="{{ __("ratings.$value") }}"
    @class([
        'opacity-25' => $rating !== $value,
        'hover:opacity-100' => $editable && $rating !== $value,
        'opacity-100' => $rating === $value,
    ])
    @click.prevent="$dispatch('input', {{ $value }})"
    @if (! $editable) disabled @endif
>
    <img src="{{ asset("/images/ratings/$value.png") }}" alt="{{ __("ratings.$value") }}" {{ $attributes }}/>
</button>