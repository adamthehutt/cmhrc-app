@props(['options' => [], 'empty' => false])
@php ($options = \Illuminate\Support\Arr::isList((array) $options) ? array_combine((array) $options, (array) $options) : $options)
<div>
    <select {{ $attributes->merge(['class' => "form-select border-gray-300"]) }}>
        @if ($empty)
            <option>{{ $empty !== true ? $empty : '' }}</option>
        @endif
        @foreach ($options as $key => $value)
            @if (is_array($value))
                @php ($subItems = \Illuminate\Support\Arr::isList((array) $value) ? array_combine((array) $value, (array) $value) : $value)
                <optgroup label="{{$key}}">
                    @foreach ($subItems as $subItemKey => $subItemValue)
                        <option value="{{$subItemKey}}">{{ $subItemValue }}</option>
                    @endforeach
                </optgroup>
            @else
                <option value="{{$key}}">{{ $value }}</option>
            @endif
        @endforeach
        {{ $slot }}
    </select>
    @error($attributes->wire('model')->value())
        <x-input-error :messages="[$message]" />
    @enderror
</div>