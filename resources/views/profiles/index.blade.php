<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Manage Profiles') }}
        </h2>
        <div class="text-lg text-gray-500 my-2 xl:w-1/2 lg:w-3/4">Each profile corresponds to a person you'll track. Most users only need one profile,
            but some need a few (such as a parent tracking multiple children).</div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <livewire:profiles.index />
                </div>
            </div>
        </div>
    </div>

    <livewire:profiles.modal />
    <livewire:profiles.symptoms-modal />
</x-app-layout>
