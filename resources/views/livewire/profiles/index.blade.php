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
                        <a href="#" wire:click.prevent="$emitTo('profiles.modal', 'edit', @js($profile->uuid))" class="text-6xl py-2" title="{{ $profile->dob->format("m/d/Y") }}">
                            {{ $profile->avatar }}
                        </a>

                        <div class="py-8 ml-3">
                            @if (empty ($profile->symptoms))
                                <a class="btn-blue btn mx-4" href="#" wire:click.prevent="$emitTo('profiles.symptoms-modal', 'edit', @js($profile->uuid))">
                                    <x-icon.cogs/> Symptoms
                                </a>
                            @else
                                <a class="btn-blue btn mx-4" href="{{ route("track.index", ["profile" => $profile->uuid]) }}">
                                    <x-icon.track/> Track
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="flex my-2 text-muted">
                        <a href="#" wire:click.prevent="$emitTo('profiles.modal', 'edit', @js($profile->uuid))">
                            <x-icon.edit /> Profile
                        </a>

                        <span>
                            @if (! empty ($profile->symptoms))
                                <a class="ml-4" href="#" wire:click.prevent="$emitTo('profiles.symptoms-modal', 'edit', @js($profile->uuid))">
                                    <x-icon.cogs/> Symptoms ({{ count($profile->symptoms) }})
                                </a>
                            @endif
                        </span>

                        <a class="ml-4" href="#" wire:click.prevent="$emitTo('profiles.diagnoses-modal', 'edit', @js($profile->uuid))">
                            <x-icon.cogs/> Diagnoses ({{ $profile->diagnoses()->count() }})
                        </a>
                    </div>
                </li>
            @endforeach
            <li class="my-3 text-right mr-8 my-4">
                <x-primary-button wire:click.prevent="$emitTo('profiles.modal', 'create')" icon="fas fa-plus-circle">Add another profile</x-primary-button>
            </li>
        @endif
    </ul>
</div>
