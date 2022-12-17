<div {{ $attributes->merge(['class' => "bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative flex"]) }} role="alert">
    <strong class="font-bold"><i class="fas fa-info-circle mr-3"></i></strong>
    <div>
        {{ $slot }}
    </div>
</div>