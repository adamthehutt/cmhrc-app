<x-modal name="profile-medications" :profile="$profile">
    <x-slot:header>Medications</x-slot:header>

    <x-instructions class="clear-both mb-5">
        <ul class="list-disc ml-6 text-gray-700">
            <li class="text-red-600 font-bold">DO WE NEED TO ADD STUFF HERE?</li>
        </ul>
    </x-instructions>


    <h3>Current medications:</h3>
    <div
        x-data="{
            adding: @entangle('adding'),
            showDosageExamples: false,
        }"
        x-on:medication-changed.window="$wire.reload()"
    >
        <div class="space-y-2">
            @forelse ($profile->currentMedications as $medication)
                <livewire:medications.list-item :medication="$medication" :key="'medication-'.$medication->id"/>
            @empty
                <div class="text-gray-500">None</div>
            @endforelse
        </div>

        <div class="my-6">
            <div x-show="'current' === adding">
                <h3>Add a current medication:</h3>
                <x-form-field>
                    <x-input-label>Name of medication</x-input-label>
                    <x-input-select empty wire:model="new.name" :options="config('medications')" />
                    <div>
                        @if ('Other' === $new->name)
                            <x-input-text wire:model="newNameOther" placeholder="Enter other" class="my-1"/>
                        @endif
                    </div>
                </x-form-field>
                <div class="flex -my-6">
                    <x-form-field class="w-1/2">
                        <x-input-label>Frequency</x-input-label>
                        <x-input-select empty wire:model="new.frequency" :options="$new->frequencyOptions" />
                        <div>
                            @if ('Other' === $new->frequency)
                                <x-input-text wire:model="new.frequency_other" placeholder="Enter other" class="my-1"/>
                            @endif
                        </div>
                    </x-form-field>
                    <x-form-field class="pl-2">
                        <x-input-label>Dosage</x-input-label>
                        <x-input-text wire:model="new.dosage" />
                        <x-form-tip x-on:click.prevent="showDosageExamples = true">
                            See some example dosages
                        </x-form-tip>
                    </x-form-field>
                </div>
                <x-alert.info x-show="showDosageExamples">
                    <x-slot:close>
                        <i class="fas fa-times" title="Hide" role="button" x-on:click.prevent="showDosageExamples=false"></i>
                    </x-slot:close>
                    <div class="font-bold">Example dosages:</div>
                    <ul>
                        <li>200mg daily</li>
                        <li>150mg AM; 150mg PM</li>
                        <li>10mg per/ML - 10 sprays every other day</li>
                        <li>1mg three times daily</li>
                        <li>1mg AM; .5mg Mid-Day; 1mg PM</li>
                        <li>2mg as needed</li>
                    </ul>
                </x-alert.info>
                <x-form-field class="w-1/2">
                    <x-input-label>Start Date</x-input-label>
                    <x-input-date wire:model.lazy="new.start_date" />
                    <x-form-tip>Can be approximate if you're not sure</x-form-tip>
                </x-form-field>
            </div>
        </div>

        <div x-show="adding" class="text-right">
            <x-secondary-button @click.prevent="adding = null">Cancel</x-secondary-button>
            <x-primary-button wire:click.prevent="saveNew">Save</x-primary-button>
        </div>

        <div class="mt-8">
            <div class="text-muted" x-show="!adding">
                <a href="#" @click.prevent="adding = 'current'"><x-icon.add/> Add a current medication</a>
            </div>
        </div>
    </div>

    <hr class="my-6"/>

    <h3>Previous medications:</h3>
    <div class="space-y-2">
        @forelse ($profile->previousMedications as $medication)
            <livewire:medications.list-item :medication="$medication" :key="'medication-'.$medication->id.'-'.$medication->end_date"/>
        @empty
            <div class="text-gray-500">None</div>
        @endforelse
    </div>

    <x-slot:footer>
        <x-secondary-button wire:click.prevent="cancel">Close</x-secondary-button>
    </x-slot:footer>
</x-modal>