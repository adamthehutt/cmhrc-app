@props(['icon' => false, 'iconRight' => false])
<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    @if ($icon && ! $iconRight) <i class="{{ $icon }} mr-2"></i> @endif
    {{ $slot }}
    @if ($icon && $iconRight) <i class="{{ $icon }} ml-2"></i> @endif
</button>
