<div class="p-6">
    <div class="mb-6 -mt-6">
        <h3 class="sr-only">
            {{ symptomName($symptom)  }}
        </h3>

        <div class="font-bold text-lg">
            {{ carbon($month)->format('F Y') }}
        </div>
    </div>

    <div
        class="bg-gradient-to-t from-white via-red-100 to-red-500 overflow-hidden"
        x-data="{
            init() {
                var chart = new ApexCharts(this.$refs.chart, this.options);
                chart.render();
            },
            get options() {
                return {
                    chart: {
                        type: 'area',
                        height: 500,
                        width: '100%',
                        toolbar: {'show':false},
                        zoom: {'enabled':true},
                        fontFamily: 'Helvetica, Arial, sans-serif',
                        foreColor: '#373d3f',
                        sparkline: {'enabled':false}
                    },
                    noData: {
                        text: 'No data reported this month',
                    },
                    colors: ['black'],
                    fill: {
                        type: 'solid',
                        colors: ['gray'],
                    },
                    series: [{
                        'name': @js(symptomName($symptom)),
                        'data': @if($noData) [] @else [ @foreach ($weeks as $average) @js($average), @endforeach  ] @endif
                    }],
                    dataLabels: {
                        enabled: false,
                        formatter: (val) => {
                            if (val < 0.3) {
                                return '{{ __('ratings.0') }}';
                            } else if (val >= 0.3 && val < 0.9) {
                                return '{{ __('ratings.0') }} / {{ __('ratings.1') }}';
                            } else if (val >= 0.9 && val < 1.1) {
                                return '{{ __('ratings.1') }}';
                            } else if (val >= 1.1 && val < 1.9) {
                                return '{{ __('ratings.1') }} / {{ __('ratings.2') }}';
                            } else if (val >= 1.9 && val < 2.1) {
                                return '{{ __('ratings.2') }}';
                            } else if (val >= 2.1 && val < 2.9) {
                                return '{{ __('ratings.2') }} / {{ __('ratings.3') }}';
                            } else {
                                return '{{ __('ratings.3') }}';
                            }
                        }
                    },
                    xaxis: {
                        categories: [@foreach($weeks as $weekNumber => $week) 'Week {{ $weekNumber }}', @endforeach],
                        tickPlacement: 'between',
                    },
                    yaxis: {
                        labels: {
                            show: true,
                            offsetX: 90,
                            formatter: (val) => {
                                if (val < 0.3) {
                                    return '{{ __('ratings.0') }}';
                                } else if (val >= 0.3 && val < 0.9) {
                                    return '{{ __('ratings.0') }} / {{ __('ratings.1') }}';
                                } else if (val >= 0.9 && val < 1.1) {
                                    return '{{ __('ratings.1') }}';
                                } else if (val >= 1.1 && val < 1.9) {
                                    return '{{ __('ratings.1') }} / {{ __('ratings.2') }}';
                                } else if (val >= 1.9 && val < 2.1) {
                                    return '{{ __('ratings.2') }}';
                                } else if (val >= 2.1 && val < 2.9) {
                                    return '{{ __('ratings.2') }} / {{ __('ratings.3') }}';
                                } else {
                                    return '{{ __('ratings.3') }}';
                                }
                            },
                            style: {
                                fontWeight: 900,
                                fontSize: 14,
                            },
                        },
                        tickAmount: 3,
                        min:0,
                        max:3,
                    },
                }
            }
        }"
    >
        <div x-ref="chart"></div>
    </div>
    <div class="mt-16 flex space-x-2 justify-between">
        <a href="#" class="text-xs" wire:click.prevent="previousMonth">
            <i class="fas fa-arrow-left mr-1"></i> Previous Month
        </a>
        <a href="#" class="text-xs" wire:click.prevent="nextMonth">
            Next Month <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
</div>
