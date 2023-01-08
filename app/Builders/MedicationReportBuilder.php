<?php

namespace App\Builders;

use App\Models\DateReport;
use App\Models\MedicationReport;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method MedicationReport firstOrCreate(array $attributes = [], array $values = [])
 */
class MedicationReportBuilder extends Builder
{
    public function forDateReport(DateReport $dateReport)
    {
        return $this
            ->whereHas("medication", function (Builder $q) use ($dateReport) {
                return $q->whereBelongsTo($dateReport->profile);
            })
            ->where("date", $dateReport->date);
    }
}