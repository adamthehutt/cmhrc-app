<div class="p-6">
    <div class="mb-6 -mt-6">
        <h3 class="sr-only">
            {{ symptomName($symptom)  }}
        </h3>

        <div class="font-bold text-lg">
            Week of {{ $startDateCarbon->format("l, M j Y") }} through {{ \Illuminate\Support\Arr::last($dates)->format("l, M j Y") }}
        </div>
    </div>
    <div
        class="bg-gradient-to-t from-white via-red-100 to-red-500"
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
                        text: 'No data reported this week',
                    },
                    colors: ['black'],
                    fill: {
                        type: 'solid',
                        colors: ['gray'],
                    },
                    series: [{
                        'name':@js(symptomName($symptom)),
                        'data': @js($noData ? [] : collect($dates)->map(fn ($date) => $this->symptomReports->firstWhere('date', $date)?->rating)->toArray())
                    }],
                    dataLabels: {
                        enabled:true,
                        formatter: (val) => {
                            switch (val) {
                                case 3: return @js(__('ratings.3'));
                                case 2: return @js(__('ratings.2'));
                                case 1: return @js(__('ratings.1'));
                                case 0: return @js(__('ratings.0'));
                            }
                        }
                    },
                    xaxis: {
                        categories: @js(collect($dates)->map(fn ($date) => $date->format('D M j'))->toArray()),
                        tickPlacement: 'between',
                    },
                    yaxis: {
                        labels: {
                            show: false,
                            formatter: (val) => {
                                switch (val) {
                                    case 3: return @js(__('ratings.3'));
                                    case 2: return @js(__('ratings.2'));
                                    case 1: return @js(__('ratings.1'));
                                    case 0: return @js(__('ratings.0'));
                                }
                            },
                            style: {
                                fontWeight: 900
                            },
                        },
                        min: 0,
                        max: 3,
                    },
                }
            }
        }"
    >
        <div x-ref="chart"></div>
    </div>
    <div class="mt-16 flex space-x-2 justify-between">
        <a href="#" class="text-xs" wire:click.prevent="previousWeek">
            <i class="fas fa-arrow-left mr-1"></i> Previous Week
        </a>
        <a href="#" class="text-xs" wire:click.prevent="nextWeek">
            Next Week <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
</div>