@extends('menu')
@section('contenido')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>
    $(document).ready(function() {
  //censos

  Highcharts.chart('container_data_censo_siget', {
            chart: {
                type: 'bar',
                // height: 1700
            },
            title: {
                align: 'left',
                text: 'Censo Facturado (GENERICO SIGET)'
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
                    text: 'Número de luminarias'
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
                        format: '{point.name}: {point.y:.0f}'
                    },
                    point: {
                        events: {
                            click: function() {
                                //console.log(this.id); // Agregado aquí
                                showData(this.id);
                            }
                        }
                    }
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> <br/>'
            },
            series: [{
                name: 'Browsers',
                colorByPoint: true,
                data: @json($data_censo_siget)
            }]
        });

        Highcharts.chart('container_data_censo_propio', {
            chart: {
                type: 'bar',
                // height: 1700
            },
            title: {
                align: 'left',
                text: 'Censo propio'
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
                    text: 'Número de luminarias'
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
                        format: '{point.name}: {point.y:.0f}'
                    },
                    point: {
                        events: {
                            click: function() {
                                //console.log(this.id); // Agregado aquí
                                showData(this.id);
                            }
                        }
                    }
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> <br/>'
            },
            series: [{
                name: 'Browsers',
                colorByPoint: true,
                data: @json($data_censo_propio)
            }]
        });

        Highcharts.chart('container_data_censo_facturado', {
            chart: {
                type: 'bar',
                // height: 1700
            },
            title: {
                align: 'left',
                text: 'Censo propio - facturado'
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
                    text: 'Número de luminarias'
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
                        format: '{point.name}: {point.y:.0f}'
                    },
                    point: {
                        events: {
                            click: function() {
                                //console.log(this.id); // Agregado aquí
                                showData(this.id);
                            }
                        }
                    }
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> <br/>'
            },
            series: [{
                name: 'Browsers',
                colorByPoint: true,
                data: @json($data_censo_facturado)
            }]
        });
    });
    </script>





<div class="space-y-5">
    <div class="grid grid-cols-12 gap-5">
        <div class="xl:col-span-6 col-span-12 lg:col-span-6 ">
            <div class="card p-6 h-full">
                <div class="space-y-5">
                    <div id="container_data_censo_siget"></div>
                </div>
            </div>
        </div>
        <div class="xl:col-span-6 col-span-12 lg:col-span-6">
            <div class="card p-6 h-full">
                <div class="space-y-5">
                    <div id="container_data_censo_propio"></div>
                </div>
            </div>
        </div>
        <div class="xl:col-span-3 col-span-12 lg:col-span-3">
        </div>
        <div class="xl:col-span-6 col-span-12 lg:col-span-6">
            <div class="card p-6 h-full">
                <div class="space-y-5">
                    <div id="container_data_censo_facturado"></div>
                </div>
            </div>
        </div>
    </div>
</div>







@endsection
