    <script>
        $(document).ready(function() {
            // consumo por tipo luminaria
            Highcharts.chart('container_data_potencia', {
                chart: {
                    type: 'column'
                },
                title: {
                    align: 'left',
                    text: 'Luminarias por potencia ({{ $tipo_nombre }}) <br>{{$meses[$mes]}} {{$anio}}'
                },
                subtitle: {
                    align: 'left',
                    text: ''
                },
                accessibility: {
                    announceNewData: {
                        enabled: true
                    }
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'Cantidad de luminarias'
                    }

                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.0f}'
                        }
                    }
                },

                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b>   <br/>'
                },

                series: [{
                    name: 'Browsers',
                    colorByPoint: true,
                    data: @json($data_rango)

                }]
            });

        });
    </script>
    <div id="container_data_potencia"></div>
