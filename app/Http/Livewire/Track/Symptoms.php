<?php

namespace App\Http\Livewire\Track;

use App\Models\DateNote;
use App\Models\Profile;
use App\Models\SymptomReport;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Symptoms extends Component
{
    public $date;

    public Profile $profile;

    public Collection $symptomReports;

    public DateNote $dateNote;

    protected $listeners = [
        'dateSelected',
    ];

    protected $rules = [
        "dateNote.notes" => [],
        "dateNote.profile_id" => [],
        "dateNote.date" => [],
    ];

    public function mount()
    {
        if (isset($this->date)) {
            $this->loadReports();
            $this->loadNote();
        }
    }

    public function dateSelected($date)
    {
        $this->date = Carbon::make($date);
        $this->loadReports();
        $this->loadNote();
    }

    public function updatedDateNote()
    {
        $this
            ->dateNote
            ->profile()->associate($this->profile)
            ->setAttribute("date", $this->date)
            ->save();
    }

    public function render()
    {
        return view('livewire.track.symptoms');
    }

    protected function loadReports()
    {
        $this->symptomReports = SymptomReport::query()
            ->whereBelongsTo($this->profile)
            ->where("date", $this->date)
            ->get();
    }

    protected function loadNote()
    {
        $this->dateNote = DateNote::query()
            ->where("profile_id", $this->profile->uuid)
            ->where("date", $this->date)
            ->firstOrNew();
    }
}
