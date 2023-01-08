<?php

namespace App\Http\Livewire\Track;

use App\Models\DateReport;
use App\Models\MedicationReport;
use App\Models\Profile;
use App\Models\SymptomReport;
use App\Rules\SymptomReportComplete;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Symptoms extends Component
{
    public $date;

    public Profile $profile;

    public Collection $symptomReports;

    public DateReport $dateReport;

    public bool $isSaved = false;

    protected $listeners = [
        'dateSelected',
        'updatedRating',
    ];

    protected $rules = [
        "dateReport.notes" => [],
        "dateReport.profile_id" => [],
        "dateReport.date" => [],
    ];

    public function mount()
    {
        if (isset($this->date)) {
            $this->loadDateReport();
            $this->loadSymptomReports();
        }
    }

    public function dateSelected($date)
    {
        $this->date = Carbon::make($date);
        $this->loadDateReport();
        $this->loadSymptomReports();

        $this->resetValidation();
    }

    public function updatedDateReport()
    {
        $this
            ->dateReport
            ->profile()->associate($this->profile)
            ->setAttribute("date", $this->date)
            ->save();
    }

    public function updatedRating(SymptomReport $report)
    {
        $this->loadSymptomReports();
    }

    public function save()
    {
        $this->resetValidation();

        $this->validate([
            "symptomReports" => [new SymptomReportComplete($this->profile)]
        ]);

        $this->dateReport->finalize()->save();
        $this->loadSymptomReports();

        $this->emit('dateFinalized');
    }

    public function getScoreProperty()
    {
        return $this->dateReport->score;
    }

    public function getSymptomsToListProperty()
    {
        $symptoms = isset($this->dateReport->score)
            ? $this->symptomReports->pluck("symptom")
            : $this->profile->symptoms;

        return collect($symptoms)->sort('sortSymptoms');
    }

    public function render()
    {
        return view('livewire.track.symptoms');
    }

    protected function loadSymptomReports()
    {
        $this->symptomReports = SymptomReport::query()
            ->whereBelongsTo($this->profile)
            ->where("date", $this->date)
            ->get();

        $this->isSaved = null !== $this->dateReport->score;
    }

    protected function loadDateReport()
    {
        $this->dateReport = DateReport::firstOrNew([
            "profile_id" => $this->profile->uuid,
            "date" => $this->date,
        ]);
    }
}
