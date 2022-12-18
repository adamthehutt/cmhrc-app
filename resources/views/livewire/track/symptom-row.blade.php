<tr wire:model="report.rating" class="group">
    <td>
        <x-symptom-name :symptom="$symptom"/>
        <div class="text-xs text-muted">
            @if (! $this->editable)
                <a href="{{ route('track.symptom', ['profile' => $profile, 'symptom' => $symptom]) }}">View trend</a>
            @endif
        </div>
    </td>
    <td class="text-center">
        <x-icon.rating :rating="$report->rating" :value="0" :editable="$this->editable"/>
    </td>
    <td class="text-center">
        <x-icon.rating :rating="$report->rating" :value="1" :editable="$this->editable"/>
    </td>
    <td class="text-center">
        <x-icon.rating :rating="$report->rating" :value="2" :editable="$this->editable"/>
    </td>
    <td class="text-center">
        <x-icon.rating :rating="$report->rating" :value="3" :editable="$this->editable"/>
    </td>
</tr>