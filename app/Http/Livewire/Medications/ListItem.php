<?php

namespace App\Http\Livewire\Medications;

use App\Models\Medication;
use Livewire\Component;

class ListItem extends Component
{
    public Medication $medication;

    protected $rules = [
        'medication.frequency' => ['required'],
        'medication.frequency_other' => ['required_if:medication.frequency,Other'],
        'medication.dosage' => ['required'],
        'medication.end_date' => [],
        'medication.reason_stopped' => [],
    ];

    public function changeDosage()
    {
        $this->validate();

        $newMedication = $this->medication->replicate(['end_date']);
        $newMedication->save();

        $endDate = $this->medication->end_date;
        $this->medication->fresh()->update(['end_date' => $endDate]);

        $this->medication = $newMedication;

        $this->dispatchBrowserEvent('medication-changed');
    }

    public function noLongerTaking()
    {
        $this->validate(['medication.end_date' => ['required']]);
        $this->medication->save();

        $this->dispatchBrowserEvent('medication-changed');
    }

    public function cancel()
    {
        $this->medication->refresh();
    }

    public function render()
    {
        return view('livewire.medications.list-item');
    }
}
