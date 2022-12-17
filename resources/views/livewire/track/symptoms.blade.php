<div class="p-6">
    <table>
        <thead>
        <tr>
            <th class="w-1/2">Symptom</th>
            <th class="w-1/8 text-center">
                {{ __('ratings.0') }}
            </th>
            <th class="w-1/8 text-center">
                {{ __('ratings.1') }}
            </th>
            <th class="w-1/8 text-center">
                {{ __('ratings.2') }}
            </th>
            <th class="w-1/8 text-center">
                {{ __('ratings.3') }}
            </th>
        </tr>
        </thead>
        @if ($date)
            @foreach ($profile->symptoms as $symptom)
                <livewire:track.symptom-row
                        :symptom="$symptom"
                        :report="$symptomReports->firstWhere('symptom', $symptom)"
                        :date="$date"
                        :profile="$profile"
                        :key="$symptom.$date"
                />
            @endforeach
        @else
            <tr>
                <td colspan="4"><i class="fas fa-spinner fa-spin"></i> One sec</td>
            </tr>
        @endif
    </table>

    <hr class="my-12"/>

    <div>
        @if ($date)
            <x-input-label>
                Notes for {{ \Illuminate\Support\Carbon::make($date)->format("F jS, Y") }}
                <x-input-textarea wire:model="dateNote.notes" class="lg:w-1/2 md:w-2/3 w-full" placeholder="Enter some notes to provide additional context"/>
            </x-input-label>
            <div class="text-muted text-sm" wire:loading.delay wire:target="dateNote.notes">
                <i class="fas fa-spinner fa-spin"></i> Saving
            </div>
        @endif
    </div>
</div>
