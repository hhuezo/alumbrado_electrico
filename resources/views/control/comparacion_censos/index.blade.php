@extends('menu')
@section('contenido')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script>
        $(document).ready(function() {

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
                            formatter: function() {
                                return this.point.name + ': ' + Highcharts.numberFormat(this.y, 0, '.',
                                    ',');
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
                            formatter: function() {
                                return this.point.name + ': ' + Highcharts.numberFormat(this.y, 0, '.',
                                    ',');
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
                            formatter: function() {
                                return this.point.name + ': ' + Highcharts.numberFormat(this.y, 0, '.',
                                    ',');
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

    <script>
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
    </script>

    <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
        id="default_modal" tabindex="-1" aria-labelledby="default_modal" aria-hidden="true">
        <form method="GET" action="{{ url('control/comparacion_censos') }}">
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
                            <button type="button"
                                class="text-slate-400 bg-transparent hover:text-slate-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center
                        dark:hover:bg-slate-600 dark:hover:text-white"
                                data-bs-dismiss="modal">
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
                            <div>
                                <label for="basicSelect" class="form-label">Departamento</label>
                                <select name="departamento" id="departamento" class="form-control w-full mt-2"
                                    onchange="getMunicipio(this.value)">
                                    <option value="">Seleccione...</option>
                                    @foreach ($departamentos as $obj)
                                        <option value="{{ $obj->id }}">{{ $obj->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="basicSelect" class="form-label">Municipio</label>
                                <select name="municipio" id="municipio" class="form-control w-full mt-2" disabled
                                    onchange="getDistrito(this.value)">

                                </select>
                            </div>
                            <div>
                                <label for="basicSelect" class="form-label">Distrito</label>
                                <select id="distrito" name="id_distrito" class="form-control w-full mt-2" required>

                                </select>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div
                            class="flex items-center justify-end p-6 space-x-2 border-t border-slate-200 rounded-b dark:border-slate-600">
                            <button data-bs-dismiss="modal"
                                class="btn inline-flex justify-center text-white bg-black-500">Aceptar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>


    <div class="space-y-5">
        <div class="grid grid-cols-12 gap-5">
            <div class="xl:col-span-12 col-span-12 lg:col-span-12 ">
                <div class="card p-6 h-full">
                    <div class="space-y-5">
                        <div class="card-title text-slate-900 dark:text-white">COMPARACIÓN DE CENSOS {{$nombreDistrito ? '('.$nombreDistrito.')':''}}
                            <button class="btn btn-dark btn-sm float-right" data-bs-toggle="modal"
                                data-bs-target="#default_modal">
                                <iconify-icon icon="mdi:filter" width="20" height="20"></iconify-icon>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>

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
