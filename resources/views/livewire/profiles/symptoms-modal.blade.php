<x-modal name="profile-symptoms" :profile="$profile">
    <x-slot:header>Symptoms to Track</x-slot:header>

    <x-instructions class="clear-both mb-5">
        <x-slot:bullets>
            <li>Select a minimum of 4 and a maximum of 10 symptoms to track daily.</li>
            <li>Choose from any category and in any combination.</li>
            <li>Pick the ones that are the most troublesome for you/your child.</li>
            <li>You can change your selections if they resolve or if others become more problematic.</li>
        </x-slot:bullets>
    </x-instructions>

    <h3>Currently tracking:</h3>
    <x-accordion>
        <x-accordion.item :badge="collect($this->sectionCount)->sum()" header="Selected symptoms">
            @forelse ($profile->symptoms as $symptom)
                <div class="my-2">
                    <x-symptom-listing :$profile :$symptom/>
                </div>
            @empty
                <div class="text-gray-500">None</div>
            @endforelse
        </x-accordion.item>
    </x-accordion>

    <hr class="my-5"/>

    <div>
        @if (($inactive = $profile->inactiveSymptoms()) && $inactive->count())
            <h3>No longer tracking:</h3>
            <x-accordion>
                <x-accordion.item header="Inactive symptoms" :badge="$inactive->count()">
                    @foreach ($inactive as $symptom)
                        <div class="my-2">
                            <x-symptom-listing :$profile :$symptom/>
                        </div>
                    @endforeach
                </x-accordion.item>
            </x-accordion>

            <hr class="my-5"/>
        @endif
    </div>

    <h3>Start tracking:</h3>
    <x-accordion>
        @foreach ($config as $categoryKey => $category)
            @if("category" === $categoryKey) @continue @endif

            <x-accordion.item :header="__('symptoms.category.'.$categoryKey)" :badge="\Illuminate\Support\Arr::get($this->sectionCount, $categoryKey) ?: null">
                @forelse (collect($category)->keys() as $symptomKey)
                    <div class="mb-3">
                        <x-input-label>
                            <input type="checkbox" class="form-checkbox mr-1"
                                   x-bind:checked="@js(in_array("$categoryKey.$symptomKey", $profile->symptoms))"
                                   wire:click.prevent="toggle(@js("$categoryKey.$symptomKey"))"
                            />
                            {{ \Illuminate\Support\Facades\Lang::has("symptoms.$categoryKey.$symptomKey") ? __("symptoms.$categoryKey.$symptomKey") : $symptomKey }}
                        </x-input-label>
                    </div>
                @empty
                    <div class="mb-3">
                        <x-input-label>
                            None
                        </x-input-label>
                    </div>
                @endforelse
            </x-accordion.item>
        @endforeach
    </x-accordion>

    <div class="my-3 flex flex-row space-x-0" x-data="{other: ''}">
        <div class="w-5/6">
            <x-input-text x-model="other" placeholder="Add your own custom symptom" class="w-full"/>
        </div>
        <div class="w-1/6">
            <button @click.prevent="$wire.addOther(other); other = ''" x-bind:disabled="!other" class="bg-gray-500 text-white enabled:hover:bg-gray-700 h-full px-4">
                <i class="fas fa-plus-circle mr-1"></i> Add
            </button>
        </div>
    </div>

    @if ($errors->any())
        <x-alert.error class="mt-4">
            <ul>
            @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
            </ul>
        </x-alert.error>
    @endif
    <x-slot:footer>
        <x-secondary-button wire:click.prevent="cancel">Cancel</x-secondary-button>
        <x-primary-button wire:click.prevent="save">Save</x-primary-button>
    </x-slot:footer>
</x-modal>