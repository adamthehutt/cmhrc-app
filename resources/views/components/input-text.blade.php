<div>
    <input type="text" {{ $attributes->merge(['class' => 'form-input border-gray-300']) }} />
    @error($attributes->wire('model')->value())
        <x-input-error :messages="[$message]" />
    @enderror
</div>
