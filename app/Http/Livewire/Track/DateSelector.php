<?php

namespace App\Http\Livewire\Track;

use Illuminate\Support\Carbon;
use Livewire\Component;

class DateSelector extends Component
{
    public $date;

    public $carbon;

    /**
     * We're going to receive from the browser a number of
     * minutes that would need to be added to the current local
     * time to equal UTC. For users in Hawai'i, for example,
     * this will always be 600. For users in New York, it will
     * be either 300 or 240, depending on Daylight Savings Time.
     */
    public $timezoneOffset;

    protected $queryString = [
        'date'
    ];

    public function mount()
    {
        if (isset($this->date)) {
            $this->updatedDate();
        }
    }

    public function updatedTimezoneOffset($offset)
    {
        if (! isset($this->date)) {
            $this->carbon = today()->subSeconds($offset);
            $this->date = $this->carbon->toDateString();

            $this->emit("dateSelected", $this->date);
        }
    }

    public function updatedDate()
    {
        $this->carbon = Carbon::make($this->date);

        $this->emit("dateSelected", $this->date);
    }

    public function nextDay()
    {
        $this->carbon->addDay();
        $this->date = $this->carbon->toDateString();

        $this->emit("dateSelected", $this->date);
    }

    public function previousDay()
    {
        $this->carbon->subDay();
        $this->date = $this->carbon->toDateString();

        $this->emit("dateSelected", $this->date);
    }

    public function render()
    {
        return view('livewire.track.date-selector');
    }
}
