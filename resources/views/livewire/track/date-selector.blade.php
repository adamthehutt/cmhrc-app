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
            <span class="align-bottom m-3 text-sm text-gray-800">
                <i class="fas fa-arrow-circle-left" role="button" title="Previous day" wire:click.prevent="previousDay"></i>
            </span>
            <x-input-date wire:model="date" aria-label="Select a date" :max="$this->localToday" required/>
            <span class="align-bottom m-3 text-sm text-gray-800">
                @if ($carbon->lt($this->localToday))
                    <i class="fas fa-arrow-circle-right" role="button" aria-label="Next day" wire:click.prevent="nextDay" wire:key="next-date-selector"></i>
                @else
                    <i class="fas fa-arrow-circle-right text-muted" title="Cannot select a future date"></i>
                @endif
            </span>
        </div>
    @endif
</div>
