<?php

namespace App\View\Components\Weather;

use App\DataObjects\WeatherDay;
use App\Models\DateReport;
use Illuminate\View\Component;

class Index extends Component
{
    public bool $canFetch = false;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public DateReport $dateReport
    )
    {
        if (! $this->dateReport->weather) {
            $this->canFetch = today()->diffInDays($this->dateReport->date) <= 7;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.weather.index', [
            'weather' => $this->dateReport->weather,
        ]);
    }
}
