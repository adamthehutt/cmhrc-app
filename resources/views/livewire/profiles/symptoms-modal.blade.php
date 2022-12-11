<x-modal name="profile-symptoms">
    <div class="p-5">
        <span class="text-4xl float-right">{{ $profile->avatar }}</span>
        <h2 class="text-xl font-bold">
            Symptoms to Track
        </h2>

        <hr class="my-5"/>

        <div class="font-bold mb-2">Currently tracking:</div>
        <x-accordion>
            <x-accordion.item :badge="collect($this->sectionCount)->sum()" header="Selected symptoms">
                @forelse ($profile->symptoms as $symptom)
                    <div class="my-2 text-sm">
                        {{ str_starts_with($symptom, "other.") ? str($symptom)->replaceFirst("other.", "") : __("symptoms.$symptom") }}
                    </div>
                @empty
                    <div class="text-gray-500">None</div>
                @endforelse
            </x-accordion.item>
        </x-accordion>

        <hr class="my-5"/>

        <div class="font-bold mb-2">Start tracking:</div>
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

    </div>
    <x-slot:footer>
        <button class="btn btn-gray" wire:click.prevent="cancel">Cancel</button>
        <button class="btn btn-blue" wire:click.prevent="save">Save</button>
    </x-slot:footer>
</x-modal>