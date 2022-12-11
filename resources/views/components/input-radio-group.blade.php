@props(['options' => []])
<div class="py-1">
    {{ $slot }}
    @foreach ($options as $key => $value)
        <x-input-radio :wire:model="$attributes->wire('model')->value()" :value="$key" :label="$value" />
    @endforeach

    @error($attributes->wire('model')->value())
        <x-input-error :messages="[$message]" />
    @enderror
</div>