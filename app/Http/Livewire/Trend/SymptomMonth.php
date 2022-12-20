<?php

namespace App\Http\Livewire\Trend;

use App\Models\Profile;
use App\Models\SymptomReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SymptomMonth extends Component
{
    public Profile $profile;

    /** @var string */
    public $month;

    public $weeks = [];

    public $symptom;

    public $symptomReports;

    public $noData = false;

    protected $queryString = [
        'month'
    ];

    public function mount()
    {
        $this->month ??= today()->format("Y-m");
        $this->fillWeeks();
    }

    public function previousMonth()
    {
        [$currentYear, $currentMonth] = explode("-", $this->month);
        if (1 === $currentMonth) {
            $previousYear = (int) $currentYear - 1;
            $previousMonth = 12;
        } else {
            $previousYear = (int) $currentYear;
            $previousMonth = (int) $currentMonth - 1;
        }

        $this->month = Carbon::create($previousYear, $previousMonth)->format("Y-m");
        $this->fillWeeks();
    }

    public function nextMonth()
    {
        [$currentYear, $currentMonth] = explode("-", $this->month);
        if (12 === $currentMonth) {
            $nextYear = (int) $currentYear + 1;
            $nextMonth = 1;
        } else {
            $nextYear = (int) $currentYear;
            $nextMonth = (int) $currentMonth + 1;
        }

        $this->month = Carbon::create($nextYear, $nextMonth)->format("Y-m");
        $this->fillWeeks();
    }

    public function render()
    {
        return view('livewire.trend.symptom-month');
    }

    protected function fillWeeks()
    {
        $this->weeks = [];

        $ratings = SymptomReport::query()
            ->forProfile($this->profile)
            ->forSymptom($this->symptom)
            ->finalized()
            ->where('date', 'LIKE', "$this->month%")
            ->pluck('rating', 'date');

        $i = 1;
        $week = Carbon::make($this->month);
        while (str($this->month)->after("-")->toString() == $week->month) {
            $nextWeek = $week->copy()->addWeek();
            $this->weeks[$i] = $ratings
                ->filter(function ($rating, $date) use ($week, $nextWeek) {
                    return carbon($date)->gte($week) && carbon($date)->lt($nextWeek);
                })
                ->average();

            $week = $nextWeek;
            $i++;
        }

        $this->noData = collect($this->weeks)->whereNotNull()->isEmpty();
    }
}
