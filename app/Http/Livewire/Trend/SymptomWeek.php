<?php

namespace App\Http\Livewire\Trend;

use App\Models\Profile;
use App\Models\SymptomReport;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use Livewire\Component;

class SymptomWeek extends Component
{
    public Profile $profile;

    public $startDate;

    public $dates = [];

    public $symptom;

    public $symptomReports;

    protected $queryString = [
        'startDate'
    ];

    public function mount()
    {
        $this->startDate ??= carbon('last monday');
        $this->fillDates();
    }

    public function updatedStartDate()
    {
        $this->fillDates();
    }

    public function previousWeek()
    {
        $this->startDate->subDays(7);
        $this->fillDates();
    }

    public function nextWeek()
    {
        $this->startDate->addDays(7);
        $this->fillDates();
    }

    public function render()
    {
        return view('livewire.trend.symptom-week');
    }

    protected function fillDates()
    {
        $this->dates = [];
        $day = $this->startDate->copy();
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

        $data = [];
        foreach ($this->dates as $date) {
            $data[] = $this->symptomReports->firstWhere('date', $date)?->rating;
        }

        $chart = app(LarapexChart::class)->lineChart();
        $chart
            ->addData(symptomName($this->symptom), $data)
            ->setXAxis(collect($this->dates)->map(
                fn (Carbon $date) => $date->format("D M j"))->toArray()
            )
            ->setColors(['black'])
            ->setGrid()
            ->setDataLabels();
    }
}
