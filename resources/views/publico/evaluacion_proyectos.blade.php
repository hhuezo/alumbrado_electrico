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
                        <form method="POST" action="{{ url('control/censo_luminaria') }}">
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

                        </form>
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

            /* $("#distrito").change(function() {
                 var distrito = $(this).val();
                 $.get("{{ url('censo_luminaria/get_companias') }}" + '/' + distrito, function(data) {
                     var _select = ''
                     for (var i = 0; i < data.length; i++)
                         _select += '<option value="' + data[i].id + '"  >' + data[i].nombre +
                         '</option>';

                     $("#compania").html(_select);
                 });
             });

                 $("#tipo_luminaria").change(function() {
                 var tipo_luminaria = $(this).val();
                 $.get("{{ url('censo_luminaria/get_potencia_promedio') }}" + '/' + tipo_luminaria,
                     function(data) {
                         if (data.length === 0) {
                             $("#div_potencia_promedio").css("display", "none");
                             $("#potencia_promedio").prop('required', false);


                             $("#div_potencia_nominal").css("display", "block");
                             $("#potencia_nominal").prop('required', true);

                             var _select =
                                 '<option value="">Favor ingresar la potencial Nominal</option>';
                         } else {
                             $("#div_potencia_promedio").css("display", "block");
                             $("#potencia_promedio").prop('required', true);

                             $("#div_potencia_nominal").css("display", "none");
                             $("#potencia_nominal").prop('required', false);

                             var _select = '<option value="">Seleccione</option>'
                             for (var i = 0; i < data.length; i++)
                                 _select += '<option value="' + data[i].id + '"  >' + data[i].potencia +
                                 '</option>';
                         }
                         $("#potencia_promedio").html(_select);
                     });

                 document.getElementById('potencia_nominal').value = "";
                 document.getElementById('consumo_mensual').value = "";
             });

             $("#potencia_promedio").change(function() {
                 var potencia_promedio = $(this).val();
                 if (potencia_promedio == "") {
                     document.getElementById('consumo_mensual').value = "";

                 } else {
                     $.get("{{ url('censo_luminaria/get_consumo_mensual') }}" + '/' + potencia_promedio,
                         function(data) {
                             if (data.length === 0) {
                                 document.getElementById('consumo_mensual').value = "";
                             } else {
                                 document.getElementById('consumo_mensual').value = data
                                     .consumo_promedio;
                             }

                         });
                 }

             });

             $("#potencia_nominal").change(function() {
                 if ($(this).val() > 0) {
                     var potencia_nominal = parseFloat($(this).val());

                     // var consumo_mensual = (potencia_nominal * 360 * 0.90) / 1000;
                     var consumo_mensual = (potencia_nominal * 360) / 1000;
                     document.getElementById('consumo_mensual').value = consumo_mensual;

                     console.log(potencia_nominal);
                 } else {
                     Swal.fire({
                         icon: 'error',
                         title: 'Oops...',
                         text: 'El valor ingresado no es válido'
                     })
                     document.getElementById('potencia_nominal').value = "";
                 }

             });

             $("#observacion").keyup(function() {
                 var numCaracteres = $(this).val().length;
                 $("#number_text").text("(" + numCaracteres + "/500)");
             });

             $("#condicion_lampara").change(function() {
                 if ($(this).is(":checked")) {
                     $("#div_tipo_falla").css("display", "none");
                     $("#tipo_falla_id").prop('required', false).val("");
                 } else {
                     $("#div_tipo_falla").css("display", "block");
                     $("#tipo_falla_id").prop('required', true);
                 }
             });*/

        });
    </script>

    <script>
        function updateSwitchText(element) {
            var switchText = document.getElementById("switchText");
            switchText.innerText = element.checked ? "Sí" : "No";
        }
    </script>



    {{--

<style>
    .highcharts-credits {
        display: none;
    }
</style>




</div>

<div class="grid grid-cols-12 gap-5 mb-5">





    <div class="2xl:col-span-12 lg:col-span-12 col-span-12">
        <div class="card">
            <div class="card-body flex flex-col p-6">
                <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                    <div class="flex-1">
                        <div class="card-title text-slate-900 dark:text-white">Evaluación de proyectos
                        </div>
                    </div>
                </header>




                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form method="POST" action="{{ url('control/censo_luminaria') }}">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-1 gap-6">




                        <div class="input-area">
                            <label for="largeInput" class="form-label">Departamento</label>
                            <select class="form-control select2" id="departamento">
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
                            <select class="form-control select2" id="municipio">
                                <option value="" selected disabled>Seleccione...</option>
                            </select>
                        </div>

                        <div class="input-area">
                            <label for="largeInput" class="form-label">Distrito</label>
                            <select class="form-control select2" name="distrito_id" id="distrito" required>
                                <option value="" selected disabled>Seleccione...</option>
                            </select>
                        </div>
                </form>
            </div>

        </div>
    </div>



</div>

<div style="display: contents;" id="render"></div>




 --}}
@endsection
