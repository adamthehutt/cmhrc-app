<?php

namespace App\Http\Livewire\Profiles;

use App\Http\Livewire\Concerns\UsesModal;
use App\Models\Profile;
use Livewire\Component;

class Modal extends Component
{
    use UsesModal;

    public Profile $profile;

    protected $rules = [
        'profile.avatar' => ['required'],
        'profile.dob' => ['required', 'date'],
        'profile.sex' => ['required'],
        'profile.gender' => ['required'],
    ];

    protected $listeners = [
        'create',
        'edit',
    ];

    public function mount()
    {
        $this->profile = new Profile();
    }

    public function create()
    {
        $this->profile = new Profile();
        $this->dispatchBrowserEvent('open-modal', 'profile-form');
    }

    public function edit(Profile $profile)
    {
        $this->profile = $profile;
        $this->dispatchBrowserEvent('open-modal', 'profile-form');
    }

    public function save()
    {
        $this->validate();

        $this
            ->profile
            ->user()->associate(auth()->user())
            ->save();

        $this->emitTo('profiles.index', 'profileCreated', $this->profile->id);
        $this->dispatchBrowserEvent('close');
    }

    public function getAvatarOptionsProperty(): array
    {
        $base = [
            '🦁' => '🦁',
            '🐶' => '🐶',
            '😺' => '😺',
            '🐯' => '🐯',
            '🐮' => '🐮',
            '🦊' => '🦊',
            '🐰' => '🐰',
            '🐸' => '🐸',
            '🐨' => '🐨',
            '🐭' => '🐭',
            '🐻' => '🐻',
        ];

        $taken = auth()->user()->profiles()->where('uuid', '!=', $this->profile->uuid)->pluck("avatar")->toArray();

        return array_diff($base, $taken);
    }

    public function render()
    {
        return view('livewire.profiles.modal');
    }
}
