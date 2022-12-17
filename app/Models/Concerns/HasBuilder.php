<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as BaseBuilder;

trait HasBuilder
{
    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param BaseBuilder $query
     * @return Builder
     */
    public function newEloquentBuilder($query): Builder
    {
        $customBuilder = str_replace("\\Models\\", "\\Builders\\", static::class) . "Builder";

        return new $customBuilder($query);
    }
}