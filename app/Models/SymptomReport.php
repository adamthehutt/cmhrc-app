<?php

namespace App\Models;

use App\Builders\SymptomReportBuilder;
use App\Models\Concerns\HasBuilder;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method  SymptomReportBuilder query()
 */
class SymptomReport extends Model
{
    use HasFactory,
        HasBuilder,
        Compoships;

    protected $guarded = [];

    protected $casts = [
        'date' => 'date:Y-m-d',
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class, "profile_id");
    }

    public function dateReport(): BelongsTo
    {
        return $this->belongsTo(DateReport::class, ["profile_id", "date"], ["profile_id", "date"]);
    }
}
