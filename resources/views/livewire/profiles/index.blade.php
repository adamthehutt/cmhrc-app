<div>
    <ul>
        @if (! auth()->user()->profiles()->exists())
            <li>
                <a href="#" x-on:click.prevent="$dispatch('open-modal', 'profile-form')" class="text-blue-900"><strong>Getting started:</strong> The first step is to create a profile <i class="fas fa-arrow-circle-right ml-1"></i></a>
            </li>
        @else
            @foreach (auth()->user()->profiles as $profile)
                <li class="my-3 p-2 hover:bg-gray-50 text-sm @if(! $loop->last) border-b @endif" wire:key="{{ $profile->uuid }}">
                    <div class="flex">
                        <span class="text-6xl py-2" title="{{ $profile->dob->format("m/d/Y") }}">{{ $profile->avatar }}</span>

                        <div class="py-8 ml-3">
                            <a class="btn-blue btn mx-4" href="#">
                                <x-icon.track/> Track
                            </a>
                        </div>
                    </div>

                    <div class="flex my-2 text-gray-500">
                        <a class="ml-4" href="#" wire:click.prevent="$emitTo('profiles.modal', 'edit', @js($profile->uuid))">
                            <x-icon.edit /> Profile
                        </a>

                        <a class="ml-4" href="#">
                            <x-icon.cogs/> Symptoms
                        </a>

                        <a class="ml-4" href="#">
                            <x-icon.cogs/> Diagnoses
                        </a>
                    </div>
                </li>
            @endforeach
            <li class="my-3 text-right mr-8 my-4">
                <a href="#" wire:click.prevent="$emitTo('profiles.modal', 'create')" class="text-blue-900"><i class="fas fa-plus-circle"></i> Add another profile</a>
            </li>
        @endif
    </ul>
</div>
