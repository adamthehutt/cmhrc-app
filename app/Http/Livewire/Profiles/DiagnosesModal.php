<?php

namespace App\Http\Livewire\Profiles;

use App\Http\Livewire\Concerns\UsesModal;
use App\Models\Diagnosis;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class DiagnosesModal extends Component
{
    use UsesModal;

    public ?Profile $profile = null;

    public Collection $diagnoses;

    public ?Diagnosis $new = null;

    public string $newOther = '';

    public ?string $adding = null;

    protected $rules = [
        'new.name' => ['required'],
        'new.year_diagnosed' => ['required', 'numeric', 'min:1940'],
        'new.current' => [],
        'newOther' => ['required_if:new.name,psychiatric.other', 'required_if:new.name,medical.other'],
    ];

    protected $messages = [
        'new.*.required' => 'Required',
        'newOther.required_if' => 'Required',
    ];

    protected $listeners = [
        'edit',
    ];

    public function mount()
    {
        $this->diagnoses = new Collection();
    }

    public function edit(Profile $profile)
    {
        $this->profile = $profile;
        $this->diagnoses = $profile->diagnoses;
        $this->new = new Diagnosis();
        $this->newOther = '';
        $this->adding = null;

        $this->dispatchBrowserEvent('open-modal', 'diagnoses');
    }

    public function delete(Diagnosis $diagnosis)
    {
        $this->diagnoses->forget($this->diagnoses->search($diagnosis));
        $diagnosis->delete();

        $this->emit('profileUpdated', $this->profile->uuid);
    }

    public function saveNew()
    {
        $this->validate();

        if ($this->newOther && str_ends_with($this->new?->name, '.other')) {
            $this->new->name = $this->newOther;
        }

        $this->new->profile()->associate($this->profile)->save();
        $this->diagnoses->add($this->new);

        $this->new = new Diagnosis();
        $this->newOther = '';
        $this->adding = null;

        $this->emit('profileUpdated', $this->profile->uuid);
    }

    public function getNewDiagnosisOptionsProperty()
    {
        return collect(Lang::get("diagnoses.{$this->adding}"))
            ->mapWithKeys(
                fn ($trans, $key) => ["{$this->adding}.{$key}" => __("diagnoses.{$this->adding}.{$key}")]
            );
    }

    public function render()
    {
        return view('livewire.profiles.diagnoses-modal');
    }
}
