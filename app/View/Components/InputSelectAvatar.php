<?php

namespace App\View\Components;

use App\Models\Profile;
use Illuminate\View\Component;

class InputSelectAvatar extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public ?Profile $exclude = null
    )
    {}

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.input-select-avatar', [
            'options' => array_diff(config("profiles.avatars"), [$this->exclude?->avatar])
        ]);
    }
}
