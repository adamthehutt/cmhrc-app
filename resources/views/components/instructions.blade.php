@props(['header' => 'Instructions'])
<div  {{ $attributes->merge(['class' => "rounded-lg bg-blue-100"]) }}>
    <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3 rounded-t-lg" role="alert">
        <i class="fas fa-info-circle fa-lg mr-2"></i>
        <p>{{ $header }}</p>
    </div>
    <div class="text-gray-700 p-3 text-sm">
        {{ $slot }}
        @if (isset($bullets))
            <ul class="list-disc ml-6 text-gray-700">
                {{ $bullets }}
            </ul>
        @endif
    </div>
</div>