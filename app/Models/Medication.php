<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read   Profile     $profile
 * @property        string      $name
 * @property        string      $frequency
 * @property        string      $frequency_other
 * @property        string      $dosage
 * @property        string      $start_date
 * @property        string      $end_date
 * @property        string      $reason_stopped
 * @property-read   array       $frequency_options
 */
class Medication extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
    ];

    protected $dates = [
        'start_date',
        'end_date',
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }

    public function reports(): HasMany
    {
        return $this->hasMany(MedicationReport::class, 'medication_id');
    }

    public function taken(): HasMany
    {
        return $this->reports()->where('taken', true);
    }

    /** Percentage of reports where medication was taken */
    public function compliance(): ?string
    {
        if ($totalCount = $this->reports()->count()) {
            return bcmul("100", bcdiv($this->taken()->count(), $totalCount, 2), 0);
        }

        return null;
    }

    public function frequencyOptions(): Attribute
    {
        return Attribute::make(
            get: fn () => [
                'Emergency as needed',
                'Daily',
                'Twice daily',
                'Three times daily',
                'Every other day',
                'Other'
            ]
        );
    }

    public static function booted()
    {
        static::saving(function (Medication $model) {
            if ("Other" !== $model->frequency) {
                $model->frequency_other = null;
            }
        });
    }
}
