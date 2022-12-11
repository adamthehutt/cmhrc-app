<?php

namespace App\Http\Livewire\Concerns;

use Livewire\Component;

/**
 * @mixin Component
 */
trait UsesModal
{
    public function cancel()
    {
        $this->resetValidation();
        $this->dispatchBrowserEvent('close');
    }
}