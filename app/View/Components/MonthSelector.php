<?php

namespace App\View\Components;

use App\Models\DateReport;
use App\Models\Profile;
use Illuminate\View\Component;

class MonthSelector extends Component
{
    public iterable $months;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public Profile $profile,
    )
    {
        $this->months = DateReport::query()
            ->distinct()
            ->whereBelongsTo($this->profile)
            ->whereNotNull('score')
            ->selectRaw('SUBSTRING(`date`, 1, 7) as month')
            ->pluck('month')
            ->sortByDesc('month')
            ->mapWithKeys(function ($month) {
                $carbon = carbon($month);
                return [$month => $carbon->format('F Y')];
            });
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.month-selector');
    }
}
