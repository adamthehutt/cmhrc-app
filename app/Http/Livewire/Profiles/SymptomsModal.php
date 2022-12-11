<?php

namespace App\Http\Livewire\Profiles;

use App\Http\Livewire\Concerns\UsesModal;
use App\Models\Profile;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class SymptomsModal extends Component
{
    use UsesModal;

    public Profile $profile;

    public array $config;

    protected $rules = [
        'profile.symptoms' => ['required', 'min:4', 'max:10']
    ];

    protected $messages = [
        'profile.symptoms.required' => 'Please select at least 4 symptoms to track',
        'profile.symptoms.min' => 'Please select at least 4 symptoms to track',
        'profile.symptoms.max' => 'Please select a maximum of 10 symptoms to track'
    ];

    protected $listeners = [
        'edit'
    ];

    public function mount()
    {
        $this->profile = new Profile();
        $this->config = Lang::get("symptoms");
    }

    public function toggle(string $symptom)
    {
        $symptoms = $this->profile->symptoms;
        if (in_array($symptom, $symptoms)) {
            $symptoms = array_diff($symptoms, [$symptom]);
        } else {
            $symptoms[] = $symptom;
        }

        $this->profile->symptoms = array_unique($symptoms);
    }

    public function addOther(string $other)
    {
        $symptoms = $this->profile->symptoms;
        $symptoms[] = "other.$other";
        $this->profile->symptoms = array_unique($symptoms);

        $this->config['other'][$other] = $other;
    }

    public function edit(Profile $profile)
    {
        $this->profile = $profile;
        $this->config['other'] = collect($this->profile->symptoms)
            ->where(fn ($key) => str_starts_with($key, "other."))
            ->mapWithKeys(function ($otherSymptom) {
                $clean = str($otherSymptom)->replaceFirst("other.", "")->toString();
                return [$clean => $clean];
            })
            ->toArray();

        $this->dispatchBrowserEvent('open-modal', 'profile-symptoms');
    }

    public function save()
    {
        $this->validate();
        $this->profile->save();

        $this->emit('profileUpdated', $this->profile->uuid);
        $this->dispatchBrowserEvent('close');
    }

    public function getSectionCountProperty()
    {
        $counts = [];
        foreach (array_keys(Lang::get("symptoms.category")) as $category) {
            $counts[$category] = collect($this->profile->symptoms)
                ->where(
                    fn ($key) => str_starts_with($key, "$category.")
                )
                ->count();
        }

        $counts['other'] = $this->getOtherSymptomsProperty()->count();

        return $counts;
    }

    public function getOtherSymptomsProperty()
    {
        return collect($this->profile->symptoms)
            ->where(
                fn ($key) => str_starts_with($key, "other.")
            );
    }

    public function render()
    {
        return view('livewire.profiles.symptoms-modal');
    }
}
