<?php

namespace Tests\Feature\SymptomReports;

use App\Models\DateReport;
use App\Models\Profile;
use App\Models\SymptomReport;

beforeEach(function () {
    $this->profile = Profile::factory()->create([
        'symptoms' => ['symptom1', 'symptom2']
    ]);

    $this->symptomReport = SymptomReport::factory()->create([
        'profile_id' => $this->profile->uuid,
        'symptom' => 'symptom1',
        'rating' => 1,
        'date' => today(),
    ]);
});

it ("can find the related date report model", function () {
    $dateReport = DateReport::create([
        'profile_id' => $this->profile->uuid,
        'date' => today(),
    ]);

    expect($this->symptomReport->dateReport->id)->toEqual($dateReport->id);
});