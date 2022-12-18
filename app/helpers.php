<?php

use Illuminate\Support\Facades\Lang;

function symptomName(string $shortCode) {
    return Lang::has("symptoms.$shortCode")
        ? __("symptoms.$shortCode")
        : str($shortCode)->replaceFirst("other.", "")->toString();
}

function sortSymptoms($a, $b) {
    if (str_starts_with($a, "other") && ! str_starts_with($b, "other")) {
        return 1;
    } elseif (! str_starts_with($a, "other") && str_starts_with($b, "other")) {
        return -1;
    } else {
        return symptomName($a) <=> symptomName($b);
    }
}

