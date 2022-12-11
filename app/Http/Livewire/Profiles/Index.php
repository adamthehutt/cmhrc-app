<?php

namespace App\Http\Livewire\Profiles;

use App\Models\Profile;
use Livewire\Component;

class Index extends Component
{
    protected $listeners = [
        'profileCreated' => '$refresh',
        'profileUpdated' => '$refresh',
        'profileDeleted' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.profiles.index');
    }
}
