<?php

namespace App\Http\Livewire\Profiles;

use App\Http\Livewire\Concerns\UsesModal;
use App\Models\Medication;
use App\Models\Profile;
use Livewire\Component;

class MedicationsModal extends Component
{
    use UsesModal;

    public Profile $profile;

    public Medication $new;

    public ?string $adding = null;

    public string $newNameOther = '';

    protected $rules = [
        'new.name' => ['required'],
        'newNameOther' => ['required_if:new.name,Other'],
        'new.frequency' => ['required'],
        'new.frequency_other' => ['required_if:new.frequency,Other'],
        'new.dosage' => ['required'],
        'new.start_date' => ['required']
    ];

    protected $messages = [
        'new.frequency_other.required_if' => 'Please select or enter the frequency'
    ];

    protected $listeners = [
        'edit'
    ];

    public function mount()
    {
        $this->profile = new Profile();
        $this->new = new Medication();
    }

    public function edit(Profile $profile)
    {
        $this->profile = $profile;
        $this->new = new Medication();
        $this->adding = null;
        $this->newNameOther = '';

        $this->dispatchBrowserEvent('open-modal', 'profile-medications');
    }

    public function saveNew()
    {
        $this->validate();
        if ('Other' === $this->new->name) {
            $this->new->name = $this->newNameOther;
        }
        $this
            ->new
            ->profile()->associate($this->profile)
            ->save();

        $this->new = new Medication();
        $this->newNameOther = '';
        $this->adding = null;

        $this->profile->load('currentMedications');
    }

    public function reload()
    {
        $this
            ->profile
            ->load('currentMedications')
            ->load('previousMedications');
    }

    public function render()
    {
        return view('livewire.profiles.medications-modal');
    }
}
