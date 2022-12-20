<?php

namespace App\Http\Livewire\Trend;

use App\Models\Profile;
use App\Models\SymptomReport;
use Livewire\Component;

class SymptomWeek extends Component
{
    public Profile $profile;

    /** @var string Needed for URL parameter */
    public $startDate;

    public $startDateCarbon;

    public $dates = [];

    public $symptom;

    public $symptomReports;

    public $noData = false;

    protected $queryString = [
        'startDate' => ['as' => 'weekStartDate']
    ];

    public function mount()
    {
        $this->startDateCarbon = carbon($this->startDate) ?? carbon('last monday');
        $this->startDate ??= $this->startDateCarbon->format("Y-m-d");
        $this->fillDates();
    }

    public function previousWeek()
    {
        $this->startDateCarbon->subDays(7);
        $this->startDate = $this->startDateCarbon->format("Y-m-d");
        $this->fillDates();
    }

    public function nextWeek()
    {
        $this->startDateCarbon->addDays(7);
        $this->startDate = $this->startDateCarbon->format("Y-m-d");
        $this->fillDates();
    }

    public function render()
    {
        return view('livewire.trend.symptom-week');
    }

    protected function fillDates()
    {
        $this->dates = [];
        $day = $this->startDateCarbon->copy();
        for ($i = 0; $i < 7; $i++) {
            $this->dates[$i] = $day;
            $day = $this->dates[$i]->copy()->addDay();
        }

        $this->symptomReports = SymptomReport::query()
            ->forProfile($this->profile)
            ->forSymptom($this->symptom)
            ->whereIn('date', collect($this->dates)->map(fn($date) => $date->format('Y-m-d')))
            ->finalized()
            ->get();

        $this->noData = 0 === $this->symptomReports->count();
    }
}
