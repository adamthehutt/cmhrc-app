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

    @if ($date)
        <table class="w-full md:w-2/3 mt-12">
            <thead>
            <tr>
                <th>Medication</th>
                <th>Taken as prescribed?</th>
            </tr>
            </thead>
            @if (! $isSaved)
                <tbody x-on:medication-changed.window="$wire.$refresh()">
                    @forelse ($profile->currentMedications as $medication)
                        <livewire:track.medication-row
                                :medication="$medication"
                                :date="$date"
                                :key="'medication-'.$medication->id"
                        />
                    @empty
                        <tr>
                            <td colspan="2" class="text-muted">
                                No current medications for this profile
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            @else
                @forelse (\App\Models\MedicationReport::forDateReport($dateReport)->get() as $report)
                    <tr class="align-text-top">
                        <td>
                            <x-medications.short-list-item :medication="$report->medication"/>
                        </td>
                        <td>
                            <x-icon.medications.report-taken :report="$report"/>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-muted">
                            No medications reported
                        </td>
                    </tr>
                @endforelse
            @endif
        </table>

        <table class="w-full md:w-2/3 mt-12">
            @if ($date)
                <thead>
                <tr>
                    <th>Notes for {{ \Illuminate\Support\Carbon::make($date)->format("F jS, Y") }}</th>
                </tr>
                </thead>
                <tr>
                    <td>
                        <x-input-textarea wire:model="dateReport.notes" class="w-full" placeholder="Enter some notes to provide additional context" aria-label="Notes for the day"/>
                        <div class="text-muted text-sm" wire:loading.delay wire:target="dateReport.notes">
                            <i class="fas fa-spinner fa-spin"></i> Working
                        </div>
                    </td>
                </tr>
            @endif
        </table>

        <table class="w-full md:w-2/3 mt-12">
            <thead>
            <tr>
                <th>Weather</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="text-center">
                    <x-weather :date-report="$dateReport"/>
                </td>
            </tr>
            </tbody>
        </table>
    @endif

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
