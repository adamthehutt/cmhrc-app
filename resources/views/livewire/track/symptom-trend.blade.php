<div class="px-6 py-3">
    <h3>
        <x-input-select aria-label="Select a symptom" :options="$this->symptomOptions" wire:model="symptom"/>
    </h3>
    {{ $reports->links() }}

    <table class="my-6 text-gray-700">
        <thead>
        <tr>
            <th class="w-1/5">Date</th>
            <th class="w-1/5 text-center">
                {{ __('ratings.0') }}
            </th>
            <th class="w-1/5 text-center">
                {{ __('ratings.1') }}
            </th>
            <th class="w-1/5 text-center">
                {{ __('ratings.2') }}
            </th>
            <th class="w-1/5 text-center">
                {{ __('ratings.3') }}
            </th>
        </tr>
        </thead>

    @forelse ($reports  as $report)
        <tr @class(["border-gray-700 border-b" => ! $loop->last])>
            <td class="bg-white">
                <a href="{{ route('track.index', ['profile' => $profile, 'date' => $report->date->toDateString()]) }}">
                    {{ __($report->date->englishDayOfWeek) }}
                </a>
                <div class="text-muted text-xs">
                    <a href="{{ route('track.index', ['profile' => $profile, 'date' => $report->date]) }}">
                        {{ $report->date->format('M d, Y') }}
                    </a>
                </div>
            </td>
            <td class="bg-gradient-to-r from-white to-yellow-100 text-center text-black">
                @if (0 === $report->rating)
                    <i class="fas fa-circle" title="{{ __('ratings.0') }}"></i>
                @endif
            </td>
            <td class="bg-gradient-to-r from-yellow-100 to-yellow-300 text-center text-black">
                @if (1 === $report->rating)
                    <i class="fas fa-circle" title="{{ __('ratings.1') }}"></i>
                @endif
            </td>
            <td class="bg-gradient-to-r from-yellow-300 to-orange-300 text-center text-black">
                @if (2 === $report->rating)
                    <i class="fas fa-circle" title="{{ __('ratings.2') }}"></i>
                @endif
            </td>
            <td class="bg-gradient-to-r from-orange-300 to-red-500 text-center text-black">
                @if (3 === $report->rating)
                    <i class="fas fa-circle" title="{{ __('ratings.3') }}"></i>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="text-muted text-lg">
                No reports have been collected for this symptom
            </td>
        </tr>
    @endforelse
    </table>
</div>
