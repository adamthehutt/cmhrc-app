<div>
    <textarea {{ $attributes->merge(['class' => 'form-input border-gray-300']) }}></textarea>
    @error($attributes->wire('model')->value())
        <x-input-error :messages="[$message]" />
    @enderror
</div>
