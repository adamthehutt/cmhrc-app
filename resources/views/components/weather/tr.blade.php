@props(['label', 'value', 'symbol' => null])
<tr>
    <td class="w-1/2 text-right !py-0 !pr-2 text-sm">
        {{ $label }}
    </td>
    <td class="font-bold !p-0">
        @if (! $symbol)
            {{ $value }}
        @elseif ('degree' === $symbol)
            {{ $value }}&deg;
        @elseif ('percent' === $symbol)
            {{ $value }}&percnt;
        @endif
    </td>
</tr>