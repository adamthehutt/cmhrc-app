<?php

namespace Tests\Feature\SymptomTracking;

use App\Http\Livewire\Track\SymptomTrend;
use App\Models\DateReport;
use App\Models\Profile;
use App\Models\SymptomReport;
use Livewire\Livewire;

beforeEach(function () {
    $this->completeDay = today();
    $this->incompleteDay = today()->subDay();

    $this->profile = Profile::factory()->create([
        'symptoms' => ['symptom1']
    ]);

    SymptomReport::factory()->create([
        'profile_id' => $this->profile->uuid,
        'symptom' => 'symptom1',
        'rating' => 1,
        'date' => $this->completeDay,
    ]);

    DateReport::factory()->create([
        'profile_id' => $this->profile->uuid,
        'date' => $this->completeDay,
        'score' => 25
    ]);

    SymptomReport::factory()->create([
        'profile_id' => $this->profile->uuid,
        'symptom' => 'symptom1',
        'rating' => 1,
        'date' => $this->incompleteDay,
    ]);
});

it ("only shows complete days", function () {
    Livewire::test(SymptomTrend::class, ['profile' => $this->profile, 'symptom' => 'symptom1'])
        ->assertSee($this->completeDay->englishDayOfWeek)
        ->assertDontSee($this->incompleteDay->englishDayOfWeek);
});