@props(['profile', 'symptom'])
<div>
    <x-symptom-name :symptom="$symptom"/>
    <div class="text-xs text-muted">
        @if ($firstReported = $profile->firstDateForSymptom($symptom))
            Reported {{ $firstReported->format("m/d/y") }}&hellip;{{ $profile->lastDateForSymptom($symptom)->format("m/d/y") }}
        @else
            Not yet reported
        @endif
    </div>
</div>