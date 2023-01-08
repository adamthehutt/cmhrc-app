<?php

namespace App\Http\Livewire\Track;

use App\Models\Medication;
use App\Models\MedicationReport;
use Livewire\Component;

class MedicationRow extends Component
{
    public Medication $medication;

    public MedicationReport $report;

    public $date;

    public $isFinal = false;

    protected $rules = [
        'report.taken' => 'required'
    ];

    public function mount()
    {
        $this->report = MedicationReport::query()
            ->firstOrCreate([
                'medication_id' => $this->medication->id,
                'date' => $this->date
            ]);
    }

    public function updated()
    {
        $this->report->save();
    }

    public function render()
    {
        return view('livewire.track.medication-row');
    }
}
