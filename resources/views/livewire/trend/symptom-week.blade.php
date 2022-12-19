<div class="p-6">
    <div class="mb-6">
        <h3><x-symptom-name :symptom="$symptom"/></h3>
        <div class="text-muted text-sm">
            Week of {{ $startDate->format("l, M j Y") }} through {{ \Illuminate\Support\Arr::last($dates)->format("l, M j Y") }}
        </div>
    </div>
    <div
        class="text-black bg-gradient-to-t from-white via-red-100 to-red-600"
        x-data="{
            init() {
                var chart = new ApexCharts(this.$refs.chart, this.options);
                chart.render();
            },
            get options() {
                return {
                    chart: {
                        type: 'line',
                        height: 500,
                        width: '100%',
                        toolbar: {'show':false},
                        zoom: {'enabled':true},
                        fontFamily: 'Helvetica, Arial, sans-serif',
                        foreColor: '#373d3f',
                        sparkline: {'enabled':false}
                    },
                    plotOptions: {
                        bar: {'horizontal':false}
                    },
                    colors: ['black'],
                    series: [{'name':@js(symptomName($symptom)),'data': @js(collect($dates)->map(fn ($date) => $this->symptomReports->firstWhere('date', $date)?->rating)->toArray()) }],
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
                        categories: @js(collect($dates)->map(fn ($date) => $date->format('D M j'))->toArray())
                    },
                    yaxis: {
                        labels: {
                            show: true,
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
                            rotate: 0,
                            offsetX: 10,
                        }
                    },
                    markers: {'show':false},
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

    <script src="//cdn.jsdelivr.net/npm/apexcharts"></script>
</div>