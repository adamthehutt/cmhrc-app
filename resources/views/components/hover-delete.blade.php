<a {{ $attributes->merge(['href' => '#', 'class' => 'float-right text-xs text-red-500 invisible group-hover:visible hover:font-bold']) }}>
    {{ $slot->isEmpty() ? 'Delete' : $slot }}
</a>