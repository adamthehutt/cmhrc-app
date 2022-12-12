<x-modal name="diagnoses" :profile="$profile">
    <x-slot:header>Diagnoses</x-slot:header>

    <x-instructions class="clear-both mb-5">
        <p class="text-gray-700">Enter current and previous diagnoses.</p>
    </x-instructions>

    <div x-data="{
        adding: @entangle('adding'),
    }">
        <div class="divide-y">
            @foreach ($diagnoses->where('current', true) as $diagnosis)
                <div wire:key="{{ $diagnosis->name }}-{{ $diagnosis->id }}" class="my-3 pt-2 group">

                    <x-hover-delete wire:click.prevent="delete({{$diagnosis->id}})" />

                    <span class="font-bold text-gray-800">
                        {{ \Illuminate\Support\Facades\Lang::has("diagnoses.{$diagnosis->name}") ? __("diagnoses.{$diagnosis->name}") : $diagnosis->name }}
                    </span>
                    <div class="text-xs text-muted">
                        Since {{ $diagnosis->year_diagnosed }}
                    </div>
                </div>
            @endforeach

            @foreach ($diagnoses->where('current', false) as $diagnosis)
                <div wire:key="{{ $diagnosis->name }}-{{ $diagnosis->id }}" class="my-3 pt-2 text-muted group">

                    <x-hover-delete wire:click.prevent="delete({{$diagnosis->id}})" />

                    <span class="font-bold text-muted">
                        {{ __("diagnoses.{$diagnosis->name}") }}
                    </span>
                    <div class="text-xs text-muted">
                        Not Current &middot; Diagnosed {{ $diagnosis->year_diagnosed }}
                    </div>
                </div>
            @endforeach
        </div>

        <div class="my-6">
            <div x-show="adding" class="flex">
                <x-form-field>
                    <x-input-label>Select a <span x-text="adding"></span> diagnosis</x-input-label>
                    <x-input-select empty wire:model="new.name" :options="$this->newDiagnosisOptions" />
                    <div>
                        @if (str_ends_with((string) $new?->name, ".other"))
                            <x-input-text wire:model="newOther" placeholder="Enter other diagnosis" class="mt-2"/>
                        @endif
                    </div>
                </x-form-field>

                <x-form-field class="pl-2">
                    <x-input-label>Year diagnosed</x-input-label>
                    <x-input-select empty wire:model="new.year_diagnosed" :options="range(date('Y'), 1940)" />
                </x-form-field>

                <x-form-field class="pl-2">
                    <x-input-label>Current?</x-input-label>
                    <input type="checkbox" class="form-checkbox" wire:model="new.current" value="1" />
                </x-form-field>
            </div>

            <div x-show="adding" class="text-right">
                <x-secondary-button @click.prevent="adding = null">Cancel</x-secondary-button>
                <x-primary-button wire:click.prevent="saveNew">Save</x-primary-button>
            </div>
        </div>

        <div class="mt-8">
            <div class="text-muted" x-show="!adding">
                <a href="#" @click.prevent="adding = 'psychiatric'"><x-icon.add/> Add a psychiatric diagnosis</a>
            </div>

            <div class="text-muted" x-show="!adding">
                <a href="#" @click.prevent="adding = 'medical'"><x-icon.add/> Add a medical diagnosis</a>
            </div>
        </div>
    </div>

    <x-slot:footer>
        <x-secondary-button wire:click.prevent="cancel">Close</x-secondary-button>
    </x-slot:footer>

</x-modal>
