<div {{ $attributes->merge(['class' => "bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative flex"]) }} role="alert">
    <strong class="font-bold"><i class="fas fa-exclamation-triangle mr-3"></i></strong>
    <div>
        {{ $slot }}
    </div>
</div>