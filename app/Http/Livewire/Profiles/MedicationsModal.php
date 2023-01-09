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

    public Medication $previous;

    public ?string $adding = null;

    public string $newNameOther = '';

    public string $previousNameOther = '';

    protected $rules = [
        'new.name' => [],
        'newNameOther' => [],
        'new.frequency' => [],
        'new.frequency_other' => [],
        'new.dosage' => [],
        'new.start_date' => [],
        'previous.name' => [],
        'previousNameOther' => [],
        'previous.frequency' => [],
        'previous.frequency_other' => [],
        'previous.dosage' => [],
        'previous.start_date' => [],
        'previous.end_date' => [],
        'previous.reason_stopped' => [],
    ];

    protected $messages = [
        'newNameOther.required_if' => 'Please enter the medication name',
        'previousNameOther.required_if' => 'Please enter the medication name',
        '*.frequency_other.required_if' => 'Please select or enter the frequency'
    ];

    protected $listeners = [
        'edit'
    ];

    public function mount()
    {
        $this->profile = new Profile();
        $this->cleanSlate();
    }

    public function edit(Profile $profile)
    {
        $this->profile = $profile;
        $this->cleanSlate();

        $this->dispatchBrowserEvent('open-modal', 'profile-medications');
    }

    public function cleanSlate()
    {
        $this->new = new Medication();
        $this->previous = new Medication();
        $this->adding = null;
        $this->newNameOther = '';
        $this->previousNameOther = '';
    }

    public function saveNew()
    {
        $this->validateNew();
        
        if ('Other' === $this->new->name) {
            $this->new->name = $this->newNameOther;
        }
        
        $this
            ->new
            ->profile()->associate($this->profile)
            ->save();

        $this->cleanSlate();

        $this->profile->load('currentMedications');
    }

    public function savePrevious()
    {
        $this->validatePrevious();

        if ('Other' === $this->previous->name) {
            $this->previous->name = $this->previousNameOther;
        }

        $this
            ->previous
            ->profile()->associate($this->profile)
            ->save();

        $this->cleanSlate();

        $this->profile->load('previousMedications');
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
    
    protected function validateNew()
    {
        $this->validate([
            'new.name' => ['required'],
            'newNameOther' => ['required_if:new.name,Other'],
            'new.frequency' => ['required'],
            'new.frequency_other' => ['required_if:new.frequency,Other'],
            'new.dosage' => ['required'],
            'new.start_date' => ['required'],
        ]);
    }
    
    protected function validatePrevious()
    {
        $this->validate([
            'previous.name' => ['required'],
            'previousNameOther' => ['required_if:previous.name,Other'],
            'previous.frequency' => ['required'],
            'previous.frequency_other' => ['required_if:previous.frequency,Other'],
            'previous.dosage' => ['required'],
            'previous.start_date' => ['required'],
            'previous.end_date' => ['required'],
            'previous.reason_stopped' => [],
        ]);
    }
}
