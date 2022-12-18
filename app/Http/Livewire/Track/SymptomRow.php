<?php

namespace App\Http\Livewire\Track;

use App\Models\Profile;
use App\Models\SymptomReport;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class SymptomRow extends Component
{
    public string $symptom;

    public ?SymptomReport $report;

    public string $date;

    public Profile $profile;

    protected $rules = [
        "report.date" => ["readonly"],
        "report.profile_id" => ["readonly"],
        "report.symptom" => ["readonly"],
        "report.rating" => [],
    ];

    protected $listeners = [
        'dateFinalized' => '$refresh',
    ];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount()
    {
        $this->report ??= (new SymptomReport())
            ->fill([
                'date' => $this->date,
                'symptom' => $this->symptom,
            ])
            ->profile()->associate($this->profile);
    }

    public function updatingReportRating($value)
    {
        if (null !== $this->report->dateReport?->score) {
            throw ValidationException::withMessages(['symptom' => ['This rating has already been recorded']]);
        }
    }

    public function updatedReportRating()
    {
        $this->report->save();

        $this->emitTo("track.symptoms", "updatedRating", $this->report->id);
    }

    public function getEditableProperty(): bool
    {
        return null === $this->report->dateReport?->score;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('livewire.track.symptom-row');
    }
}
