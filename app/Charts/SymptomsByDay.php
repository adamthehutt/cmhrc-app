<?php

namespace App\Charts;

use App\Models\DateReport;
use App\Models\Profile;
use App\Models\SymptomReport;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SymptomsByDay
{
    protected Profile $profile;

    protected string $month;

    protected string $monthName;

    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function setProfile(Profile $profile): static
    {
        $this->profile = $profile;

        return $this;
    }

    public function setMonth(string $month): static
    {
        $this->month = $month;
        $carbon = Carbon::make($this->month);
        $this->monthName = __($carbon->englishMonth) . ' ' . $carbon->year;

        return $this;
    }

    public function build(): LarapexChart
    {
        $dates = DateReport::whereNotNull('score')
            ->whereBelongsTo($this->profile)
            ->where('date', 'LIKE', "$this->month%")
            ->orderBy('date')
            ->get();

        $xAxis = $dates->pluck('date')->map(fn ($date) => $date->format('M j, Y'))->toArray();

        return $this->chart->lineChart()
            ->setTitle('Symptom Severity Index for '.$this->monthName)
            ->addData('Symptom Severity Index', $dates->pluck('score')->toArray())
            ->setXAxis($xAxis)
            ->setColors(['black'])
            ->setGrid()
            ->setDataLabels();
    }
}
