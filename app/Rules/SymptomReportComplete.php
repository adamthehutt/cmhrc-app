<?php

namespace App\Rules;

use App\Models\Profile;
use App\Models\SymptomReport;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Collection;

class SymptomReportComplete implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(
        public Profile $profile,
    )
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  Collection&SymptomReport[]  $value
     * @return bool
     */
    public function passes($attribute, mixed $value)
    {
        return collect($value)->whereNotNull('rating')->count()
            >= count($this->profile->symptoms);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __("validation.custom.symptoms.rating-missing");
    }
}
