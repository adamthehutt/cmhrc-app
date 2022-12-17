<?php

namespace App\Builders;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Builder;

class SymptomReportBuilder extends Builder
{
    public function forProfile(Profile $profile): static
    {
        $this->query->where("profile_id", $profile->uuid);

        return $this;
    }

    public function forSymptom(string $symptom): static
    {
        $this->query->where("symptom", $symptom);

        return $this;
    }
}