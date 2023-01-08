<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property string $uuid
 */
class Profile extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = "uuid";

    protected $attributes = [
        'symptoms' => '[]',
    ];

    protected $casts = [
        'dob' => 'date:Y-m-d',
        'symptoms' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function diagnoses(): HasMany
    {
        return $this->hasMany(Diagnosis::class, 'profile_id');
    }

    public function medications(): HasMany
    {
        return $this->hasMany(Medication::class, 'profile_id')->orderBy('name');
    }

    public function currentMedications(): HasMany
    {
        return $this->medications()->whereNull('end_date');
    }

    public function previousMedications(): HasMany
    {
        return $this->medications()->whereNotNull('end_date');
    }

    public function firstDateForSymptom(string $symptom): ?Carbon
    {
        $date = SymptomReport::query()
            ->forProfile($this)
            ->forSymptom($symptom)
            ->min("date");

        return Carbon::make($date);
    }

    public function lastDateForSymptom(string $symptom): ?Carbon
    {
        $date = SymptomReport::query()
            ->forProfile($this)
            ->forSymptom($symptom)
            ->max("date");

        return Carbon::make($date);
    }

    public function inactiveSymptoms(): Collection
    {
        return SymptomReport::query()
            ->distinct()
            ->forProfile($this)
            ->whereNotIn("symptom", $this->symptoms)
            ->pluck("symptom");
    }
}
