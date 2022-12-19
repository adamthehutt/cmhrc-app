<x-app-layout>
    <x-slot name="header">
        <x-avatar-lg :$profile class="float-right"/>

        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Symptom Tracker') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="my-2">
                <x-month-selector :$profile/>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div id="symptoms-by-month-chart"></div>
            </div>
        </div>
    </div>

    <script src="{{ $chart->cdn() }}"></script>
    <script>
        var options =
        {
            chart: {
              type: '{!! $chart->type() !!}',
              height: {!! $chart->height() !!},
              width: '{!! $chart->width() !!}',
              toolbar: {!! $chart->toolbar() !!},
              zoom: {!! $chart->zoom() !!},
              fontFamily: '{!! $chart->fontFamily() !!}',
              foreColor: '{!! $chart->foreColor() !!}',
              sparkline: {!! $chart->sparkline() !!},
              events: {
                xAxisLabelClick: function(event, chartContext, config) {
                  var date = event.target.innerHTML;
                  var day = date.split(" ")[1].replace(/,/, "");
                  if (1 === day.length) {
                    day = '0'+day;
                  }
                  window.location.href='../?date={{ carbon($month)->format('Y-m') }}-'+day;
                },
              }
            },
            plotOptions: {
                bar: {!! $chart->horizontal() !!}
            },
            colors: {!! $chart->colors() !!},
            series: {!! $chart->dataset() !!},
            dataLabels: {!! $chart->dataLabels() !!},
            @if($chart->labels())
            labels: {!! json_encode($chart->labels(), true) !!},
            @endif
            title: {
                text: "{!! $chart->title() !!}"
            },
            subtitle: {
                text: '{!! $chart->subtitle() !!}',
                align: '{!! $chart->subtitlePosition() !!}'
            },
            xaxis: {
                categories: {!! $chart->xAxis() !!}
            },
            grid: {!! $chart->grid() !!},
            markers: {!! $chart->markers() !!},
            @if($chart->stroke())
            stroke: {!! $chart->stroke() !!},
            @endif
        }
        var chart = new ApexCharts(document.querySelector("#symptoms-by-month-chart"), options);
        chart.render();
    </script>
    <style>
        .apexcharts-xaxis {
            cursor: pointer !important;
        }
    </style>
</x-app-layout>
