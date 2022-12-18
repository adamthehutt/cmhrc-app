<?php

namespace Tests\Feature\SymptomTracking;

use App\Http\Livewire\Track\Symptoms;
use App\Models\Profile;
use App\Models\SymptomReport;
use App\Rules\SymptomReportComplete;
use Livewire\Livewire;

it ("blocks saving a day if report is incomplete", function () {
    $profile = Profile::factory()->create([
        'symptoms' => ['symptom1', 'symptom2']
    ]);

    SymptomReport::factory()->create([
        'profile_id' => $profile->uuid,
        'symptom' => 'symptom1',
        'rating' => 1,
        'date' => today(),
    ]);

    Livewire::test(Symptoms::class, ['profile' => $profile, 'date' => today()])
        ->call('save')
        ->assertHasErrors(['symptomReports' => SymptomReportComplete::class]);

    expect(SymptomReport::whereNotNull('saved_at')->exists())->toBeFalse();
});

it ("allows saving a day if report is complete", function () {
    $profile = Profile::factory()->create([
        'symptoms' => ['symptom1', 'symptom2']
    ]);

    SymptomReport::factory()->create([
        'profile_id' => $profile->uuid,
        'symptom' => 'symptom1',
        'rating' => 1,
        'date' => today(),
    ]);

    SymptomReport::factory()->create([
        'profile_id' => $profile->uuid,
        'symptom' => 'symptom2',
        'rating' => 3,
        'date' => today(),
    ]);

    $livewire = Livewire::test(Symptoms::class, ['profile' => $profile, 'date' => today()]);
    $livewire
        ->call('save')
        ->assertHasNoErrors();

    $symptomReports = $livewire->get("symptomReports");
    foreach ($symptomReports as $report) {
        expect($report->saved_at)->not->toBeNull();
    }

    expect(SymptomReport::whereNull('saved_at')->exists())->toBeFalse();
    $this->assertDatabaseCount("symptom_reports", 2);
});
