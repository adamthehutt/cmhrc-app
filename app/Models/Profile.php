<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = "uuid";

    protected $casts = [
        'dob' => 'date:Y-m-d'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}