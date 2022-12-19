<?php

namespace App\View\Components;

use App\Models\Profile;
use App\Models\SymptomReport;
use Illuminate\View\Component;

class InputSelectSymptom extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public Profile $profile,
    )
    {}

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $options = SymptomReport::query()
            ->forProfile($this->profile)
            ->finalized()
            ->pluck("symptom")
            ->unique()
            ->mapWithKeys(
                fn ($symptom) => [$symptom => symptomName($symptom)]
            )
            ->toArray();

        return view('components.input-select-symptom', compact('options'));
    }
}
