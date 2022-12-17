<?php

namespace App\Actions;

use App\Models\Profile;
use App\Models\SymptomReport;

class CalculateScoreForDay
{
    public function __construct(
        public Profile $profile,
        public mixed $date,
    ) {}

    public function __invoke()
    {
        $reports = SymptomReport::query()
            ->forProfile($this->profile)
            ->where("date", $this->date)
            ->pluck("rating");

        $average = $reports->sum() / $reports->count();
        $percent = $average / 3 * 100;

        return round($percent);
    }
}