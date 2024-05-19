@extends('menu')
@section('contenido')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<style>
    .highcharts-credits {
        display: none;
    }
</style>
@if ($verificacion_data > 0)
<script>
    $(document).ready(function() {
        // consumo por tipo luminaria
        Highcharts.chart('container_tipo_luminaria', {
            chart: {
                type: 'column'
            },
            title: {
                align: 'left',
                text: 'Consumo por tipo de luminaria (kwh) <br>{{ $meses[$mes] }} {{ $anio }} '
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
                    text: 'Total de consumo kilovatio hora'
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
                        format: '{point.y:.2f}'
                    }
                }
            },

            tooltip: {
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>',
                formatter: function() {
                    return '<span style="font-size:11px">' + this.series.name + '</span><br>' +
                        '<span style="color:' + this.point.color + '">' + this.point.name +
                        '</span>: <b>' + Highcharts.numberFormat(this.point.y, 2, '.', ',') +
                        '</b> Kwh<br/>';
                }
            },

            series: [{
                name: '',
                colorByPoint: true,
                data: @json($data_tipo_luminaria)

            }]
        });

        Highcharts.chart('container_tipo_luminaria_pie', {
            chart: {
                type: 'pie'
            },
            title: {
                align: 'left',
                text: 'Consumo por tipo de luminaria  (kwh)<br>{{ $meses[$mes] }} {{ $anio }} '
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
                    text: 'Total de consumo kilovatio hora'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        formatter: function() {
                            return '<b>' + this.point.name + '</b>: ' + Highcharts.numberFormat(this
                                .point.y, 2, '.', ',');
                        }
                    },
                    showInLegend: true
                }
            },

            tooltip: {
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b>',
                formatter: function() {
                    return '<span style="color:' + this.point.color + '">' + this.point.name +
                        '</span>: <b>' + Highcharts.numberFormat(this.point.y, 2, '.', ',') +
                        ' Kwh</b>';
                }
            },

            series: [{
                name: 'Browsers',
                colorByPoint: true,
                data: @json($data_tipo_luminaria)

            }]
        });

        // conteo por tipo luminaria

        Highcharts.chart('container_conteo_luminaria', {
            chart: {
                type: 'column'
            },
            title: {
                align: 'left',
                text: 'Cantidad por tipo de luminaria<br>{{ $meses[$mes] }} {{ $anio }}'
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
                data: @json($data_numero_luminaria)

            }]
        });

        Highcharts.chart('container_conteo_luminaria_pie', {
            chart: {
                type: 'pie'
            },
            title: {
                align: 'left',
                text: 'Cantidad por tipo de luminaria<br>{{ $meses[$mes] }} {{ $anio }}'
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
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.y:.0f}'
                    },
                    showInLegend: true
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b>   <br/>'
            },

            series: [{
                name: 'Browsers',
                colorByPoint: true,
                data: @json($data_numero_luminaria)

            }]
        });

        Highcharts.chart('container_data_rango_potencia_instalada', {
            chart: {
                type: 'pie',
                // height: 1700
            },
            title: {
                align: 'left',
                text: 'Potencia nominal por tecnología<br>{{ $meses[$mes] }} {{ $anio }}'
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
                data: @json($data_rango_potencia_instalada)
            }]
        });
    });

    function showData(id) {
        $.ajax({
            url: '{{ url('home/rango_potencia_data ') }}/' + id + '/' + {{$anio}} + '/' + {{$mes}},
            type: 'GET',
            success: function(response) {
                // Aquí manejas la respuesta del servidor
                $('#rango_data').html(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Aquí manejas los errores de la petición
                console.error(textStatus, errorThrown);
            }
        });
    }

    function getMunicipio(id) {
        var Departamento = id;

        //funcionpara las municipios
        $.get("{{url('get_municipios')}}" + '/' + Departamento, function(data) {

            //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
            console.log(data);
            var _select = '<option value="">Seleccione...</option>'
            for (var i = 0; i < data.length; i++)
                _select += '<option value="' + data[i].id + '"  >' + data[i].nombre +
                '</option>';

            $("#municipio").html(_select);
            $("#municipio").attr('disabled', false);

        });
    }

    function getDistrito(id) {
        var Municipio = id;


        //funcionpara las municipios
        $.get("{{url('get_distritos')}}" + '/' + Municipio, function(data) {

            //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
            console.log(data);
            var _select = '<option value="">Seleccione...</option>'
            for (var i = 0; i < data.length; i++)
                _select += '<option value="' + data[i].id + '"  >' + data[i].nombre +
                '</option>';

            $("#distrito").html(_select);
            $("#distrito").attr('disabled', false);

        });
    }

    function seleccione(){
        var id = document.getElementById('distrito').value;
        $.get(`{{ url('get_option') }}/${id}`, function(data) {
            console.log(data);
            $("#id_distrito").val(data.id);
            $("#nombre_distrito").val(data.nombre);
        });
    }
</script>
@endif

<div class="card">
    <div class="card-body flex flex-col p-6">
        <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
            <div class="flex-1">
                <div class="card-title text-slate-900 dark:text-white">Censo genérico
                    <button class="btn btn-dark btn-sm float-right" data-bs-toggle="modal" data-bs-target="#default_modal" >
                        <iconify-icon icon="mdi:filter" width="20" height="20"></iconify-icon>
                    </button>
                </div>
            </div>
        </header>

        <div class="card-body flex flex-col p-4">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-7">
                <div class="input-area relative">
                    <label for="largeInput" class="form-label">Año</label>
                    <input type="text" readonly class="form-control" value="{{$anio ? $anio: date('Y')}}">
                </div>
                <div class="input-area relative">
                    <label for="largeInput" class="form-label">Mes</label>
                    <input type="text" readonly class="form-control" value="{{$mes ? $meses[$mes]: $meses[date('m')]}}">
                </div>
                <div class="input-area">
                    <label for="largeInput" class="form-label">Distrito</label>
                    <div class="relative">
                        <input type="text" class="form-control !pr-12"  readonly value="{{$nombre_distrito }}">
                        <!-- <button data-bs-toggle="modal" data-bs-target="#default_modal" class="absolute right-0 top-1/2 -translate-y-1/2 w-9 h-full border-l border-l-slate-200 dark:border-l-slate-700 flex items-center justify-center">
                            <iconify-icon icon="heroicons-solid:search"></iconify-icon>
                        </button> -->
                    </div>
                </div>

                <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
                    id="default_modal" tabindex="-1" aria-labelledby="default_modal" aria-hidden="true">
                    <form method="GET" action="{{ url('home') }}">
                        <div class="modal-dialog relative w-auto pointer-events-none">
                            <div
                                class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-paddingrounded-md outline-none text-current">
                                <div class="relative bg-white rounded-lg shadow dark:bg-slate-700">
                                    <!-- Modal header -->
                                    <div
                                        class="flex items-center justify-between p-5 border-b rounded-t dark:border-slate-600 bg-black-500">
                                        <h3 class="text-xl font-medium text-white dark:text-white capitalize">
                                            Seleccione distrito
                                        </h3>
                                        <button type="button" class="text-slate-400 bg-transparent hover:text-slate-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center
                                            dark:hover:bg-slate-600 dark:hover:text-white" data-bs-dismiss="modal">
                                            <svg aria-hidden="true" class="w-5 h-5" fill="#ffffff" viewbox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10
                                                    11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <!-- Modal body -->

                                    <div class="p-6 space-y-4">
                                        <div class="input-area relative">
                                            <label for="largeInput" class="form-label">Año</label>
                                            <select class="form-control" name="anio">
                                                @for ($i = date('Y'); $i >= 2023; $i--)
                                                <option value="{{ $i }}" {{ $anio==$i ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="input-area relative">
                                            <label for="largeInput" class="form-label">Mes</label>
                                            <select class="form-control" name="mes">
                                                @foreach ($meses as $key => $value)
                                                <option value="{{ $key }}" {{ $mes==$key ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label for="basicSelect" class="form-label">Departamento</label>
                                            <select name="departamento" id="departamento"
                                                class="form-control w-full mt-2" onchange="getMunicipio(this.value)">
                                                @foreach($departamentos as $obj)
                                                <option value="{{$obj->id}}">{{$obj->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label for="basicSelect" class="form-label">Municipio</label>
                                            <select name="municipio" id="municipio" class="form-control w-full mt-2"
                                                disabled onchange="getDistrito(this.value)">
                                                @foreach($municipios as $obj)
                                                <option value="{{$obj->id}}">{{$obj->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label for="basicSelect" class="form-label">Distrito</label>
                                            <select id="distrito" name="id_distrito" class="form-control w-full mt-2" disabled>
                                                @foreach($distritos as $obj)
                                                <option value="{{$obj->id}}">{{$obj->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Modal footer -->
                                    <div
                                        class="flex items-center justify-end p-6 space-x-2 border-t border-slate-200 rounded-b dark:border-slate-600">
                                        <button data-bs-dismiss="modal"
                                            class="btn inline-flex justify-center text-white bg-black-500"
                                            >Aceptar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>
<div class="content-wrapper transition-all duration-150 " id="content_wrapper">

    @if ($verificacion_data > 0)
    <div class="page-content">

        <div class="transition-all duration-150 container-fluid" id="page_layout">
            <div id="content_layout">



                <div class="space-y-5">
                    <div class="grid grid-cols-12 gap-5">
                        <div class="xl:col-span-5 col-span-12 lg:col-span-5 ">
                            <div class="card p-6 h-full">
                                <div class="space-y-5">
                                    <div id="container_tipo_luminaria_pie"></div>
                                </div>
                            </div>
                        </div>
                        <div class="xl:col-span-7 col-span-12 lg:col-span-7">
                            <div class="card p-6 h-full">
                                <div class="space-y-5">
                                    <div id="container_tipo_luminaria"></div>
                                </div>
                            </div>
                        </div>


                        <div class="xl:col-span-5 col-span-12 lg:col-span-5 ">
                            <div class="card p-6 h-full">
                                <div class="space-y-5">
                                    <div id="container_conteo_luminaria_pie"></div>
                                </div>
                            </div>
                        </div>


                        <div class="xl:col-span-7 col-span-12 lg:col-span-7">
                            <div class="card p-6 h-full">
                                <div class="space-y-5">
                                    <div id="container_conteo_luminaria"></div>
                                </div>
                            </div>
                        </div>

                        <div class="xl:col-span-12 col-span-12 lg:col-span-12 ">
                            <div class="card p-6 h-full">
                                <div class="space-y-5">
                                    <div id="container_data_rango_potencia_instalada"></div>
                                </div>
                            </div>
                        </div>

                        <div class="xl:col-span-12 col-span-12 lg:col-span-12 ">
                            <div class="card p-6 h-full">
                                <div class="space-y-5" id="rango_data">

                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection