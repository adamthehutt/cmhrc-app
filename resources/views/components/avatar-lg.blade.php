@props(['profile'])
<span {{ $attributes->merge(['class' => "text-4xl"]) }}>{{ $profile->avatar }}</span>