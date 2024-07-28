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
<script>
    $(document).ready(function() {

                // consumo por tipo luminaria
                Highcharts.chart('container_base_siget', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        align: 'left',
                        text: 'Gasto mensual ($) <br>{{ $meses[$mes] }} {{ $anio }} '
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
                            text: 'Gasto mensual'
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
                                '</span>: <b>$' + Highcharts.numberFormat(this.point.y, 2, '.', ',') +
                                '</b><br/>';
                        }
                    },

                    series: [{
                        name: 'Censo Generico',
                        colorByPoint: true,
                        data: @json($data_base_siget)

                    },{
                        name: 'Inventario Actual AP',
                        colorByPoint: true,
                        data: @json($data_censo_luminaria)
                    },
                    {
                        name: 'Diferencia',
                        colorByPoint: true,
                        data: @json($diferencia_data)
                    }]
                });


            });

            function getMunicipio(id) {
                var Departamento = id;

                //funcionpara las municipios
                $.get("{{ url('get_municipios') }}" + '/' + Departamento, function(data) {

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
                $.get("{{ url('get_distritos') }}" + '/' + Municipio, function(data) {

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

            function seleccione() {
                var id = document.getElementById('distrito').value;
                $.get(`{{ url('get_option') }}/${id}`, function(data) {
                    console.log(data);
                    $("#id_distrito").val(data.id);
                    $("#nombre_distrito").val(data.nombre);
                });
            }
</script>

<div class="card">
    <div class="card-body flex flex-col p-6">
        <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
            <div class="flex-1">
                <div class="card-title text-slate-900 dark:text-white">Estimación de factura general
                </div>
            </div>
        </header>

        <div class="card-body flex flex-col p-4">
            <form method="GET" action="{{ url('control/EstimacionFacturaGeneral') }}">

                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-7">
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
                    <div class="input-area relative">
                        <label for="largeInput" class="form-label">Departamento</label>
                        <select name="departamento" id="departamento" class="form-control w-full mt-2"
                            onchange="getMunicipio(this.value)" required>
                            <option value="">Seleccione</option>
                            @foreach ($departamentos as $obj)
                            <option value="{{ $obj->id }}" {{ $id_departamento==$obj->id ? 'selected' : '' }}>
                                {{ $obj->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-area relative">
                        <label for="largeInput" class="form-label">Municipio</label>
                        <select name="municipio" id="municipio" class="form-control w-full mt-2"
                            onchange="getDistrito(this.value)" required>
                            <option value="">Seleccione</option>
                            @if ($municipios)
                            @foreach ($municipios as $obj)
                            <option value="{{ $obj->id }}" {{ $id_municipio==$obj->id ? 'selected' : '' }}>
                                {{ $obj->nombre }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="input-area">
                        <label for="largeInput" class="form-label">Distrito</label>
                        <div class="relative">
                            <select id="distrito" name="id_distrito" class="form-control w-full mt-2">
                                <option value="">Seleccione</option>
                                @if ($municipios)
                                @foreach ($distritos as $obj)
                                <option value="{{ $obj->id }}" {{ $id_distrito==$obj->id ? 'selected' : '' }}>
                                    {{ $obj->nombre }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <div
                    class="flex items-center justify-end p-6 space-x-2 border-t border-slate-200 rounded-b dark:border-slate-600">
                    <button type="submit"
                        class="btn inline-flex justify-center text-white bg-black-500">Aceptar</button>
                </div>
            </form>
        </div>

    </div>
</div>
<div class="content-wrapper transition-all duration-150 " id="content_wrapper">

    @if ($verificacion_data > 0 && $municipios)
    <div class="page-content">

        <div class="transition-all duration-150 container-fluid" id="page_layout">
            <div id="content_layout">



                <div class="space-y-5">
                    <div class="grid grid-cols-12 gap-5">
                        <div class="xl:col-span-12 col-span-12 lg:col-span-12">
                            <div class="card p-6 h-full">
                                <div class="space-y-5">
                                    <div id="container_base_siget"></div>
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
