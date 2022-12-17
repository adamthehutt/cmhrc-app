@props(['symptom'])
{{ \Illuminate\Support\Facades\Lang::has("symptoms.$symptom") ? __("symptoms.$symptom") : str($symptom)->replaceFirst("other.", "") }}