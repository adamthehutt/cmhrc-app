<?php

namespace App\Models;

use App\Builders\SymptomReportBuilder;
use App\Models\Concerns\HasBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method  SymptomReportBuilder query()
 */
class SymptomReport extends Model
{
    use HasFactory,
        HasBuilder;

    protected $guarded = [];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class, "profile_id");
    }

    public function isSaved(): bool
    {
        return null !== $this->saved_at;
    }
}
