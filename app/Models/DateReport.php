<?php

namespace App\Models;

use App\Actions\CalculateScoreForDay;
use App\Casts\AsWeatherDay;
use App\DataObjects\WeatherDay;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property WeatherDay $weather
 */
class DateReport extends Model
{
    use HasFactory,
        Compoships;

    protected $attributes = [
        'notes' => '',
    ];

    protected $guarded = [];

    protected $casts = [
        'date' => 'date:Y-m-d',
        'weather' => AsWeatherDay::class,
    ];

    protected $dates = [
        'date'
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class, "profile_id");
    }

    public function symptomReports(): HasMany
    {
        return $this
            ->hasMany(SymptomReport::class, ['profile_id', 'date'], ['profile_id', 'date']);
    }

    public function finalize(): static
    {
        $this->score = (new CalculateScoreForDay($this->profile, $this->date))();

        return $this;
    }
}
