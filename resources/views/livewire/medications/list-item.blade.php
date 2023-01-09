<div
    x-data="{
        dosageChanged: false,
        noLongerTaking: false,
        reset() {
            this.dosageChanged = false;
            this.noLongerTaking = false;
            this.$wire.cancel()
        }
    }"
    class="p-2 rounded"
    x-bind:class="{'bg-gray-200 border-gray-700': dosageChanged || noLongerTaking}"
    x-on:medication-changed.window="reset()"
>
    {{ $medication->name }}
    <div class="text-xs text-muted">
        {{ $medication->frequency_other ?: $medication->frequency }}
        &middot; {{ $medication->dosage }}
        @if (! $medication->getOriginal('end_date'))
            &middot; Since {{ $medication->start_date->format('m/d/y') }}
            &middot; <a href="#" x-on:click.prevent="dosageChanged = true; noLongerTaking = false; $wire.set('medication.end_date', today())">Change dosage</a>
            &middot; <a href="#" x-on:click.prevent="noLongerTaking = true; dosageChanged = false; $wire.set('medication.end_date', today())">Stop taking</a>
            <span x-show="dosageChanged || noLongerTaking">
                &middot; <a href="#" class="text-red-600" x-on:click.prevent="reset">Never mind</a>
            </span>
        @else
            &middot; {{ $medication->start_date->format('m/d/y') }} &ndash; {{ $medication->end_date->format('m/d/y') }}
            @if ($medication->reason_stopped)
                <div class="mt-1">
                    <strong>Reason stopped:</strong> <em>{{ $medication->reason_stopped }}</em>
                </div>
            @endif
        @endif
    </div>

    <div x-cloak x-show="dosageChanged">
        <div class="flex">
            <x-form-field class="md:w-1/2 w-full">
                <x-input-label>New Frequency</x-input-label>
                <x-input-select wire:model="medication.frequency" :options="$medication->frequency_options"/>
                @if ("Other" === $medication->frequency)
                    <x-input-text wire:model="medication.frequency_other" class="mt-2" placeholder="Other frequency"/>
                @endif
            </x-form-field>
            <x-form-field>
                <x-input-label>New Dosage</x-input-label>
                <x-input-text wire:model="medication.dosage" />
            </x-form-field>
        </div>
        <div class="text-right text-green-500 text-sm">
            <a href="#" wire:click.prevent="changeDosage">
                <i class="fas fa-check mr-1"></i> Save new dosage
            </a>
        </div>
    </div>

    <div x-cloak x-show="noLongerTaking">
        <div class="md:flex">
            <x-form-field class="md:w-1/2 w-full">
                <x-input-label>End date</x-input-label>
                <x-input-date wire:model.lazy="medication.end_date" />
            </x-form-field>
            <x-form-field class="md:w-1/2 w-full">
                <x-input-label>Reason for stopping:</x-input-label>
                <x-input-textarea wire:model.lazy="medication.reason_stopped" />
                <x-form-tip>Add a few notes to explain why this medication was stopped</x-form-tip>
            </x-form-field>
        </div>
        <div class="text-right text-red-600 text-sm">
            <a href="#" wire:click.prevent="noLongerTaking">
                <i class="fas fa-archive mr-1"></i> Archive medication
            </a>
        </div>
    </div>
</div>