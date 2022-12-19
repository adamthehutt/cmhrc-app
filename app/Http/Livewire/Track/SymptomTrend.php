<?php

namespace App\Http\Livewire\Track;

use App\Models\Profile;
use App\Models\SymptomReport;
use Livewire\Component;
use Livewire\WithPagination;

class SymptomTrend extends Component
{
    use WithPagination;

    public Profile $profile;

    public string $symptom;

    public function getSymptomOptionsProperty(): array
    {
        return SymptomReport::query()
            ->forProfile($this->profile)
            ->finalized()
            ->pluck("symptom")
            ->mapWithKeys(
                fn ($symptom) => [$symptom => symptomName($symptom)]
            )
            ->toArray();
    }

    public function render()
    {
        return view('livewire.track.symptom-trend', [
            'reports' => SymptomReport::query()
                ->forProfile($this->profile)
                ->forSymptom($this->symptom)
                ->finalized()
                ->orderByDesc('symptom_reports.date')
                ->with(["dateReport"])
                ->paginate(30)
        ]);
    }
}
