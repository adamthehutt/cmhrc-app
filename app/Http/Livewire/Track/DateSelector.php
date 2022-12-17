<?php

namespace App\Http\Livewire\Track;

use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class DateSelector extends Component
{
    public $date;

    public Carbon $carbon;

    /**
     * We're going to receive from the browser a number of
     * minutes that would need to be added to the current local
     * time to equal UTC. For users in Hawai'i, for example,
     * this will always be 600. For users in New York, it will
     * be either 300 or 240, depending on Daylight Savings Time.
     */
    public $timezoneOffset = 0;

    public function mount()
    {
        if (request()->has("date")) {
            $this->date = request("date");
        }
    }

    public function updatedTimezoneOffset($offset)
    {
        if (! isset($this->date)) {
            $this->carbon = now()->subSeconds($offset);
            $this->date = $this->carbon->toDateString();

            $this->emit("dateSelected", $this->date);
        }
    }

    public function updatingDate($value)
    {
        $this->preventFutureDate($value);
    }

    public function updatedDate()
    {
        $this->carbon = Carbon::make($this->date);

        $this->emit("dateSelected", $this->date);
    }

    public function getLocalTodayProperty(): string
    {
        return now()->subSeconds($this->timezoneOffset)->toDateString();
    }

    public function nextDay()
    {
        $nextDate = $this->carbon->copy()->addDay();
        $this->preventFutureDate($nextDate);

        $this->carbon = $nextDate;
        $this->date = $this->carbon->toDateString();

        $this->emit("dateSelected", $this->date);
    }

    public function previousDay()
    {
        $this->resetValidation();

        $this->carbon->subDay();
        $this->date = $this->carbon->toDateString();

        $this->emit("dateSelected", $this->date);
    }

    public function render()
    {
        return view('livewire.track.date-selector');
    }

    protected function preventFutureDate(string | Carbon $date)
    {
        $this->resetValidation();

        if (Carbon::make($date)->setTime(0,0)->gt($this->getLocalTodayProperty())) {
            throw ValidationException::withMessages(['date' => ['May not select a future date']]);
        }
    }
}
