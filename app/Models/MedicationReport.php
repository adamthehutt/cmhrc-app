<?php

namespace App\Models;

use App\Builders\MedicationReportBuilder;
use App\Models\Concerns\HasBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method MedicationReportBuilder query()
 */
class MedicationReport extends Model
{
    use HasFactory;
    use HasBuilder;

    public $timestamps = false;

    protected $attributes = [
        'taken' => true
    ];

    protected $casts = [
        'taken' => 'bool'
    ];

    protected $guarded = [];

    protected $with = ['medication'];

    public function medication(): BelongsTo
    {
        return $this->belongsTo(Medication::class);
    }

    public function isFinalized(): bool
    {
        return DateReport::whereBelongsTo($this->medication->profile)
            ->where('date', $this->date)
            ->whereNotNull('score')
            ->exists();
    }
}
