<?php

namespace App\Builders;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;

class SymptomReportBuilder extends Builder
{
    public function forProfile(Profile $profile): static
    {
        $this->query->where("symptom_reports.profile_id", $profile->uuid);

        return $this;
    }

    public function forSymptom(string $symptom): static
    {
        $this->query->where("symptom_reports.symptom", $symptom);

        return $this;
    }

    public function finalized(): static
    {
        $this->whereHas("dateReport", function ($q) {
            $q->where("score", "!=", null);
        });

        return $this;
    }
}