<div
    x-data="{
        selected: @js(request()->route('month')),

        init() {
            this.$watch('selected', (val) => window.location.href = val);
        }
    }"
>
    <x-input-select
            aria-label="Select a month"
            :options="$months"
            x-model="selected"
    />
</div>
