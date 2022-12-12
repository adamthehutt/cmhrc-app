<x-modal name="profile-form" :profile="$profile">
    <x-slot:header>{{ $profile?->exists ? 'Edit profile' : 'Create a profile'}}</x-slot:header>
    <x-form-field>
        <x-input-label>Choose an Avatar</x-input-label>
        <x-input-select wire:model="profile.avatar" class="text-xl" :options="$this->avatarOptions" empty/>
        <x-form-tip>For privacy reasons, you'll use this image to identify
            the profile instead of a name.</x-form-tip>
    </x-form-field>

    <x-form-field>
        <x-input-label>Date of Birth</x-input-label>
        <x-input-date wire:model.defer="profile.dob"/>
    </x-form-field>

    <x-form-field>
        <x-input-label>Sex <span class="text-gray-500 text-sm">(assigned at birth)</span></x-input-label>
        <x-input-select wire:model="profile.sex" :options="[
            'Male' => 'Male',
            'Female' => 'Female',
            'Other' => 'Other',
        ]" empty/>
    </x-form-field>

    <x-form-field>
        <x-input-label>Gender <span class="text-gray-500 text-sm">(identity)</span></x-input-label>
        <x-input-select wire:model="profile.gender" :options="[
            'Male' => 'Male',
            'Female' => 'Female',
            'Nonbinary' => 'Non-binary',
        ]" empty/>
    </x-form-field>

    <x-slot:footer>
        <x-secondary-button wire:click.prevent="cancel">Cancel</x-secondary-button>
        <x-primary-button wire:click.prevent="save">Save</x-primary-button>
    </x-slot:footer>
</x-modal>