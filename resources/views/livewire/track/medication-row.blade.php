<tr class="align-text-top">
    <td>
        <livewire:medications.list-item :medication="$medication" :key="'medication-'.$medication->id" />
    </td>
    <td>
        <x-input-radio-group :options="[1 => 'Yes, taken as prescribed', 0 => 'No']" wire:model="report.taken"/>
        @if (! $report->taken)
            <div class="text-xs text-red-600">Explain in notes if needed</div>
        @endif
    </td>
</tr>