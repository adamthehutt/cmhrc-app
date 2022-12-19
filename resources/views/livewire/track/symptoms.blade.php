<div class="p-6">
    <div class="lg:w-2/3 mx-auto">
        @if (! $isSaved)
            <x-alert.info class="mb-3">
                This day's report has not been finalized yet. When you're finished recording for the day,
                click "Save and Score" to save your ratings and have the day scored.
            </x-alert.info>
        @else
            <div @class([
              "mb-3 p-3 border text-center text-lg relative group",
              "bg-green-200 border-green-500" => $this->score <= 25,
              "bg-gray-200 border-gray-500" => $this->score > 25 && $this->score < 75,
              "bg-red-200 border-red-500" => $this->score >= 75,
            ])>
                <div class="float-right text-sm">
                    <a href="{{ route('track.chart', ['profile' => $profile, 'month' => carbon($date)->format('Y-m')]) }}" class="opacity-50 group-hover:opacity-100">
                        <i class="fas fa-chart-line" role="button" title="View trend"></i>
                    </a>
                </div>

                The Symptom Severity Index for {{ \Illuminate\Support\Carbon::make($date)->format("M jS, Y") }} is
                <div class="font-bold text-4xl">
                    {{ $this->score }} / 100
                </div>
            </div>
        @endif
    </div>

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
            @foreach ($this->symptomsToList as $symptom)
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
                <x-input-textarea wire:model="dateReport.notes" class="lg:w-1/2 md:w-2/3 w-full" placeholder="Enter some notes to provide additional context"/>
            </x-input-label>
            <div class="text-muted text-sm" wire:loading.delay wire:target="dateReport.notes">
                <i class="fas fa-spinner fa-spin"></i> Working
            </div>
        @endif
    </div>

    <div>
        @error('symptomReports')
            <x-alert.error class="my-4">
                <x-input-error :messages="$errors->get('symptomReports')"/>
            </x-alert.error>
        @enderror
    </div>

    <div class="text-right">
        @if (! $isSaved)
            <x-primary-button wire:click.prevent="save">Save and Score</x-primary-button>
        @endif
    </div>
</div>
