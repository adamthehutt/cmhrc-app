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
    <ul class="text-xs text-muted flex">
        <li class="bg-gray-200 rounded font-bold px-2 mr-1">
            {{ $medication->frequency_other ?: $medication->frequency }}
        </li>
        <li class="bg-gray-200 rounded font-bold px-2 mr-1">
            {{ $medication->dosage }}
        </li>
        @if ($compliance = (int) $medication->compliance())
            <li @class(['rounded font-bold px-2 mr-1 bg-gray-200', 'text-red-600' => $compliance < 80, 'text-green-800' => $compliance > 90]) title="Compliance percentage">
                {{ $medication->compliance() }}%
            </li>
        @endif
        @if (! $medication->getOriginal('end_date'))
            <li class="bg-gray-200 rounded font-bold px-2 mr-1">
                Since {{ $medication->start_date->format('m/d/y') }}
            </li>
            <li class="border-gray-300 hover:bg-gray-200 border rounded font-bold px-2 mr-1">
                <a href="#" x-on:click.prevent="dosageChanged = true; noLongerTaking = false; $wire.set('medication.end_date', today())">
                    <i class="fas fa-prescription mr-1"></i>
                    Change dosage
                </a>
            </li>
            <li class="border-gray-300 hover:bg-gray-200 border rounded font-bold px-2 mr-1">
                <a href="#" x-on:click.prevent="noLongerTaking = true; dosageChanged = false; $wire.set('medication.end_date', today())">
                    <i class="fas fa-trash mr-1"></i>
                    Stop taking
                </a>
            </li>
        @else
            <li class="bg-gray-200 rounded font-bold px-2 mr-1">
                {{ $medication->start_date->format('m/d/y') }} &ndash; {{ $medication->end_date->format('m/d/y') }}
            </li>
        @endif
    </ul>
    <div>
    @if ($medication->reason_stopped)
        <div class="mt-1">
            <strong>Reason stopped:</strong> <em>{{ $medication->reason_stopped }}</em>
        </div>
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
        <div class="text-right text-sm">
            <a href="#" wire:click.prevent="changeDosage" class="text-green-500">
                <i class="fas fa-check mr-1"></i> Save new dosage
            </a>
            <a href="#" class="ml-2 text-red-600" x-on:click.prevent="reset">
                <i class="fas fa-times mr-1"></i> Never mind
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
        <div class="text-right text-sm">
            <a href="#" wire:click.prevent="noLongerTaking" class="text-green-500">
                <i class="fas fa-archive mr-1"></i> Archive medication
            </a>
            <a href="#" class="ml-2 text-red-600" x-on:click.prevent="reset">
                <i class="fas fa-times mr-1"></i> Never mind
            </a>
        </div>
    </div>
</div>