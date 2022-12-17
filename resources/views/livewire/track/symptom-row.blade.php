<tr wire:model="report.rating">
    <td>
        <x-symptom-name :symptom="$symptom"/>
    </td>
    <td class="text-center">
        <x-icon.rating :rating="$report->rating" :value="0" :editable="! $report->isSaved()"/>
    </td>
    <td class="text-center">
        <x-icon.rating :rating="$report->rating" :value="1" :editable="! $report->isSaved()"/>
    </td>
    <td class="text-center">
        <x-icon.rating :rating="$report->rating" :value="2" :editable="! $report->isSaved()"/>
    </td>
    <td class="text-center">
        <x-icon.rating :rating="$report->rating" :value="3" :editable="! $report->isSaved()"/>
    </td>
</tr>