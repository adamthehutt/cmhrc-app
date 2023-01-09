@props(['report'])
<i @class(['fas', 'fa-check text-green-600' => $report->taken, 'fa-times text-red-600' => ! $report->taken])