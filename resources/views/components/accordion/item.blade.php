@props(['expanded' => false, 'header', 'badge' => null])
<div
    x-data="{
        expanded: {{ json_encode($expanded) }},
        accordion: function (event) {
            if (event.detail.item === this.$refs.self) {
                this.expanded = ! this.expanded;
            } else if (this.expanded && event.detail.wrapper === this.$refs.wrapper) {
                this.expanded = false;
            }
        },
    }"
    x-ref="self"
    x-on:accordion.window="accordion"
>
    <div class="font-bold p-3" x-on:click="$dispatch('accordion', { item: $refs.self, wrapper: $refs.wrapper })" role="button" x-bind:class="{'bg-gray-50': !expanded, 'bg-gray-200': expanded}">
        <i class="fas fa-caret-right mr-1" x-show="!expanded"></i>
        <i class="fas fa-caret-down mr-1" x-show="expanded"></i>
        {{ __($header) }}

        <div class="font-bold float-right text-white bg-gray-700 px-2 rounded-lg">
            @isset($badge) {{ $badge }} @endisset
        </div>
    </div>
    <div class="p-4" x-show="expanded">
        {{ $slot }}
    </div>
</div>