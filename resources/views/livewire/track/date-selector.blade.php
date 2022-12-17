<div
    class="p-6 text-center"
    x-data="{
        init() {
            this.$wire.$set('timezoneOffset', (new Date).getTimezoneOffset());
        }
    }"
>
    @if ($carbon)
        <h3>
            {{ __($carbon->englishDayOfWeek) }}, {{ __($carbon->englishMonth) }} {{ $carbon->ordinal('day') }}, {{ $carbon->year }}
        </h3>
        <div class="flex justify-center">
            <a href="#" class="align-bottom m-3 text-sm text-gray-800" title="Previous day" wire:click.prevent="previousDay">
                <i class="fas fa-arrow-circle-left" role="button"></i>
            </a>
            <x-input-date wire:model="date" aria-label="Select a date"/>
            <a href="#" class="align-bottom m-3 text-sm text-gray-800" title="Next day" wire:click.prevent="nextDay">
                <i class="fas fa-arrow-circle-right" role="button"></i>
            </a>
        </div>
    @endif
</div>
