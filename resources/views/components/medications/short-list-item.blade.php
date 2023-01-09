@props(['medication'])
<div>
    {{ $medication->name }}
    <div class="text-xs text-muted">
        {{ $medication->frequency_other ?: $medication->frequency }}
        &middot; {{ $medication->dosage }}
    </div>
</div>