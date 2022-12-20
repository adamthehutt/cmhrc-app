<x-app-layout>
    <x-slot name="header">
        <x-avatar-lg :$profile class="float-right"/>

        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Symptom Tracker') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{view: window.location.hash.replace(/#/, '') || 'week'}">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="float-right m-4 text-sm">
                    <x-primary-button @click="view='week'; window.location.hash='#week'" x-bind:class="{'opacity-50 hover:opacity-100': view !== 'week'}">By Week</x-primary-button>
                    <x-primary-button @click="view='month'; window.location.hash='#month'" x-bind:class="{'opacity-50 hover:opacity-100': view !== 'month'}">By Month</x-primary-button>
                </div>

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
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg my-6 pt-4" x-show="view === 'week'">

                <div>
                    @if ($symptom = request()->input('symptom'))
                        <livewire:trend.symptom-week :profile="$profile" :symptom="$symptom"/>
                    @endif
                </div>

            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg my-6 pt-4" x-show="view === 'month'">
                <div>
                    @if ($symptom = request()->input('symptom'))
                        <livewire:trend.symptom-month :profile="$profile" :symptom="$symptom"/>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="//cdn.jsdelivr.net/npm/apexcharts"></script>
</x-app-layout>
