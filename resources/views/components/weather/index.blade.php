@props(['dateReport'])
<div
    x-data="{
        fetchWeather() {
            navigator.geolocation.getCurrentPosition((position) => {
                this.$wire.fetchWeather(position.coords.latitude, position.coords.longitude);
            });
        },
    }"
>
    @if ($dateReport?->weather)
        <div class="flex items-center justify-center">
            <img src="{{ $dateReport->weather->icon }}" alt="{{ $dateReport->weather->description }}"/>
            <div>
                <div class="font-bold text-lg">{{ $dateReport->weather->location }}</div>
                <div class="text-sm">{{ $dateReport->weather->description }}</div>
            </div>
        </div>
        <div class="text-center">
            <table class="mt-3 sm:w-1/2 sm:float-left">
                <x-weather.tr label="Temp (high)" :value="$dateReport->weather->tempMax" symbol="degree"/>
                <x-weather.tr label="Temp (low)" :value="$dateReport->weather->tempMin" symbol="degree"/>
                <x-weather.tr label="Temp (range)" :value="$dateReport->weather->tempVariation()" symbol="degree"/>
                <x-weather.tr label="Humidity" :value="$dateReport->weather->humidity" symbol="percent" />
                <x-weather.tr label="Precipitation" :value="$dateReport->weather->precipitation . ' inches'"/>
            </table>
            <table class="mt-3 sm:w-1/2 sm:float-right">
                <x-weather.tr label="Sunrise" :value="$dateReport->weather->sunrise"/>
                <x-weather.tr label="Sunset" :value="$dateReport->weather->sunset"/>
                <x-weather.tr label="Moon" :value="$dateReport->weather->moon"/>
            </table>
        </div>
    @else
        <div>
            <x-primary-button x-on:click.prevent="fetchWeather()" wire:target="fetchWeather" wire:loading.attr="disabled">
                Add weather data for the day
            </x-primary-button>
        </div>
        <div wire:target="fetchWeather" wire:loading.remove>
            <x-form-tip>Note: this requires access to your current location</x-form-tip>
        </div>
        <div wire:target="fetchWeather" wire:loading>
            <i class="fas fa-spinner fa-spin mr-1"></i> Hang on a sec, looking up weather data
        </div>
    @endif
</div>