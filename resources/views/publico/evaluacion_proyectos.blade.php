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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<div class="space-y-5">
    <div class="grid grid-cols-12 gap-5">

        <div class="xl:col-span-6 col-span-12 lg:col-span-7">
            <div class="card h-full">
                <div class="card-header">
                    <h4 class="card-title">Evaluación de proyectos</h4>
                </div>
                <div class="card-body p-6">
                    <input type="hidden" id="tipo" value="1">
                    @csrf
                    <div class="input-area">
                        <label for="largeInput" class="form-label">Departamento</label>
                        <select class="form-control" id="departamento">
                            <option value="" selected disabled>Seleccione...</option>
                            @foreach ($departamentos as $obj)
                            <option value="{{ $obj->id }}">
                                {{ $obj->nombre }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="input-area">
                        <label for="largeInput" class="form-label">Municipio</label>
                        <select class="form-control" id="municipio">
                            <option value="" selected disabled>Seleccione...</option>
                        </select>
                    </div>

                    <div class="input-area">
                        <label for="largeInput" class="form-label">Distrito</label>
                        <select class="form-control" name="distrito_id" id="distrito" required>
                            <option value="" selected disabled>Seleccione...</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>


        <div class="xl:col-span-6 col-span-12 lg:col-span-7">
            <div class="card h-full">

                <div class="card-body p-6">
                    <div id="divGrafico"></div>
                </div>
            </div>
        </div>

    </div>
    <div class="grid grid-cols-12 gap-5" id="render">
    </div>
</div>






<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>


<script type="text/javascript">
    $(document).ready(function() {
            let chart;
            $("#distrito").change();

            $("#departamento").change(function() {
                // var para la Departamento
                const Departamento = $(this).val();

                $.get("{{ url('censo_luminaria/get_municipios') }}" + '/' + Departamento, function(data) {
                    //console.log(data);
                    muni = $("#municipio");
                    muni.val(null).trigger("change");
                    var _select = '<option value="">SELECCIONE</option>';
                    for (var i = 0; i < data.length; i++)
                        _select += '<option value="' + data[i].id + '">' + data[i].nombre +
                        '</option>';
                    muni.html(_select);
                    muni.val(null).trigger("change");
                    var Municipio = muni.val();
                    //getDistritos(Municipio);

                });
            });


            $("#municipio").change(function() {
                var Municipio = $(this).val();
                getDistritos(Municipio);
            });


            function getDistritos(Municipio) {
                //console.log("este es el municipio: ", Municipio);
                if (Municipio != "") {
                    $.get("{{ url('censo_luminaria/get_distritos') }}" + '/' + Municipio, function(data) {
                        //console.log(data);
                        var _select = '<option value="">SELECCIONE</option>'
                        for (var i = 0; i < data.length; i++)
                            _select += '<option value="' + data[i].codigo + '"  >' + data[i].nombre +
                            '</option>';

                        $("#distrito").html(_select);
                    });
                }
            }

            $("#distrito").change(function() {
                getConteoLuminaria();
                getGrafico();
            });


            function getConteoLuminaria() {
                let distrito = $('#distrito').val();
                let parametros = {
                    "distrito": distrito
                };

                $.ajax({
                    type: "get",
                    url: "{{ URL::to('publico/getConteoLuminaria') }}",
                    data: parametros,
                    success: function(response) {
                        //console.log(response);
                        let formTecnologias = $('#render');
                        formTecnologias.empty();
                        if (response !== null && !$.isEmptyObject(response)) {

                            // response contiene los datos en el formato adecuado
                            //chart.series[0].setData(response);


                            formTecnologias.html(response);

                        }
                    }
                });
            }

            function getGrafico() {
                let distrito = $('#distrito').val();
                let parametros = {
                    "distrito": distrito
                };

                $.ajax({
                    type: "get",
                    url: "{{ URL::to('publico/evaluacion_proyectos/get_grafico/') }}/" + distrito,
                    success: function(response) {
                        //console.log(response);
                        let formTecnologias = $('#divGrafico');
                        formTecnologias.empty();
                        if (response !== null && !$.isEmptyObject(response)) {

                            // response contiene los datos en el formato adecuado
                            //chart.series[0].setData(response);


                            formTecnologias.html(response);

                        }
                    }
                });
            }

        });
</script>

<script>
    function updateSwitchText(element) {
            var switchText = document.getElementById("switchText");
            switchText.innerText = element.checked ? "Sí" : "No";
        }
</script>

@endsection
