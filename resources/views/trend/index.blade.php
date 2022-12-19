<x-app-layout>
    <x-slot name="header">
        <x-avatar-lg :$profile class="float-right"/>

        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Symptom Tracker') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div
                    class="px-6 py-3"
                    x-data="{
                        symptom: @js(request()->input('symptom')),
                        init() {
                            this.$watch('symptom', (val) => window.location.href='/trend/{{ $profile->uuid }}?symptom='+val);
                        }
                    }"
                >
                    <x-input-select-symptom :$profile x-model="symptom" />
                </div>

                <div>
                    @if ($symptom = request()->input('symptom'))
                        <livewire:trend.symptom-week :profile="$profile" :symptom="$symptom"/>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
