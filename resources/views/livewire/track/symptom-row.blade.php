<tr wire:model="report.rating">
    <td>
        <x-symptom-name :symptom="$symptom"/>
    </td>
    <td class="text-center">
        <x-icon.rating-0 :rating="$report->rating"/>
    </td>
    <td class="text-center">
        <x-icon.rating-1 :rating="$report->rating"/>
    </td>
    <td class="text-center">
        <x-icon.rating-2 :rating="$report->rating"/>
    </td>
    <td class="text-center">
        <x-icon.rating-3 :rating="$report->rating"/>
    </td>
</tr>