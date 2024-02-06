@extends('menu')
@section('contenido')
    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])

    <div class="grid grid-cols-12 gap-5 mb-5">

        <div class="2xl:col-span-12 lg:col-span-12 col-span-12">
            <div class="card">
                <div class="card-body flex flex-col p-6">
                    <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                        <div class="flex-1">
                            <div class="card-title text-slate-900 dark:text-white">Nuevo censo

                                <a href="{{ url('control/censo_luminaria/show_map/') }}">
                                    <button class="btn btn-dark btn-sm float-right">
                                        <iconify-icon icon="icon-park-solid:back" style="color: white;" width="18">
                                        </iconify-icon>
                                    </button>
                                </a>
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
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-7">



                            <input type="hidden" name="latitud" value="{{ $latitude }}" class="form-control">
                            <input type="hidden" name="longitud" value="{{ $longitude }}" class="form-control">

                            {{-- <div class="input-area">
                                <label for="largeInput" class="form-label">Codigo luminaria</label>
                                <input type="text" name="codigo_luminaria" value="{{ old('codigo_luminaria') }}" required
                                    class="form-control">

                            </div> --}}

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Departamento</label>
                                <select class="form-control" id="departamento">
                                    @foreach ($departamentos as $obj)
                                        <option value="{{ $obj->id }}"
                                            {{ $id_departamento == $obj->id ? 'selected' : '' }}>{{ $obj->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Distrito</label>
                                <select class="form-control" name="distrito_id" id="distrito" required>
                                    @foreach ($distritos as $obj)
                                        <option value="{{ $obj->id }}"
                                            {{ $id_distrito == $obj->id ? 'selected' : '' }}>{{ $obj->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Dirección</label>
                                <input type="text"  name="direccion" value="{{ $direccion }}" class="form-control">
                            </div>



                            <div class="input-area">
                                <label for="largeInput" class="form-label">Tipo luminaria</label>
                                <select class="form-control" name="tipo_luminaria_id" id="tipo_luminaria">
                                    @foreach ($tipos as $obj)
                                        <option value="{{ $obj->id }}">{{ $obj->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Potencia promedio</label>
                                <select class="form-control" id="potencia_promedio">
                                    <option value="">No aplica</option>
                                </select>
                            </div>

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Potencia nominal</label>
                                <input type="number" step="0.001" name="potencia_nominal" id="potencia_nominal"
                                    value="{{ old('potencia_nominal') }}" required class="form-control">
                            </div>

                           <div class="input-area">
                                <label for="largeInput" class="form-label">Consumo mensual</label>
                                <input type="number" step="0.001" name="consumo_mensual" id="consumo_mensual"
                                    value="{{ old('consumo_mensual') }}" required class="form-control">
                            </div>

                            {{--<div class="input-area">
                                <label for="largeInput" class="form-label">Desidad luminicia</label>
                                <input type="number" step="0.001" name="decidad_luminicia"
                                    value="{{ old('decidad_luminicia') }}" class="form-control">
                            </div>--}}

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Fecha ultimo censo</label>
                                <input type="date" name="fecha_ultimo_censo" value="{{ old('fecha_ultimo_censo') }}"
                                    required class="form-control">
                            </div>

                        </div>
                        <div>&nbsp;</div>
                        <div style="text-align: right;">
                            <button type="submit" style="margin-right: 18px" class="btn btn-dark">Aceptar</button>
                        </div>
                    </form>


                </div>






            </div>
        </div>
    </div>





    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>


    <script type="text/javascript">
        $(document).ready(function() {

            $("#departamento").change(function() {
                // var para la Departamento
                const Departamento = $(this).val();


                $.get("{{ url('censo_luminaria/get_distritos') }}" + '/' + Departamento, function(data) {
                    console.log(data);
                    var _select = ''
                    for (var i = 0; i < data.length; i++)
                        _select += '<option value="' + data[i].id + '">' + data[i].nombre +
                        '</option>';
                    $("#distrito").html(_select);

                });
            });


            /* $("#municipio").change(function() {
                 var Municipio = $(this).val();
                 $.get("{{ url('censo_luminaria/get_distritos') }}" + '/' + Municipio, function(data) {
                     var _select = ''
                     for (var i = 0; i < data.length; i++)
                         _select += '<option value="' + data[i].id + '"  >' + data[i].nombre +
                         '</option>';

                     $("#distrito").html(_select);
                 });
             });*/

            $("#tipo_luminaria").change(function() {
                var tipo_luminaria = $(this).val();
                $.get("{{ url('censo_luminaria/get_potencia_promedio') }}" + '/' + tipo_luminaria,
                    function(data) {
                        if (data.length === 0) {
                            var _select = '<option value="">No aplica</option>';
                            $("#potencia_nominal").prop("disabled", false);
                        } else {
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
                    $("#potencia_nominal").prop("disabled", true);

                } else {
                    $.get("{{ url('censo_luminaria/get_consumo_mensual') }}" + '/' + potencia_promedio,
                        function(data) {
                            if (data.length === 0) {
                                document.getElementById('consumo_mensual').value = "";
                                $("#potencia_nominal").prop("disabled", false);
                            } else {
                                document.getElementById('consumo_mensual').value = data
                                    .consumo_promedio;
                                $("#potencia_nominal").prop("disabled", true);
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



        });
    </script>






@endsection


{{-- <style>
        #loading {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
        }

        #loading img {
            width: 50px; /* ajusta el tamaño de la imagen según sea necesario */
            height: 50px;
        }
    </style>
    <div class="grid grid-cols-12 gap-5 mb-5">

        <div class="2xl:col-span-12 lg:col-span-12 col-span-12">
            <div class="card">
                <div class="card-body flex flex-col p-6">
                    <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                        <div class="flex-1">
                            <div class="card-title text-slate-900 dark:text-white">Nuevo censo

                                <a href="{{ url('control/censo_luminaria/') }}">
                                    <button class="btn btn-dark btn-sm float-right">
                                        <iconify-icon icon="icon-park-solid:back" style="color: white;" width="18">
                                        </iconify-icon>
                                    </button>
                                </a>
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
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-7">

                            <div id="loading">
                                <img src="{{ asset('img/loading.gif') }}" style="width: 100px; height:100px" alt="Cargando...">
                            </div>

                            <input type="hidden" id="latitud" name="latitud" class="form-control">
                            <input type="hidden" id="longitud" name="longitud" class="form-control">

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Localización</label>
                                <div class="relative">
                                    <input type="text" id="localizacion" class="form-control !pr-12" readonly>
                                    <button onclick="obtenerUbicacion()" type="button"
                                        class="absolute btn-dark right-0 top-1/2 -translate-y-1/2 w-9 h-full border-l border-l-slate-200 dark:border-l-slate-700 flex items-center justify-center">
                                        <iconify-icon icon="mdi:location" style="color: white;"
                                            width="24"></iconify-icon>
                                    </button>
                                </div>
                            </div>

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Codigo luminaria</label>
                                <input type="text" name="codigo_luminaria" value="{{ old('codigo_luminaria') }}" required
                                    class="form-control">

                            </div>

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Departamento</label>
                                <select class="form-control" id="departamento">
                                    <option value="">Seleccione</option>
                                    @foreach ($departamentos as $obj)
                                        <option value="{{ $obj->id }}">{{ $obj->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Distrito</label>
                                <select class="form-control" name="distrito_id" id="distrito" required>
                                </select>
                            </div>



                            <div class="input-area">
                                <label for="largeInput" class="form-label">Tipo luminaria</label>
                                <select class="form-control" name="tipo_luminaria_id" id="tipo_luminaria">
                                    @foreach ($tipos as $obj)
                                        <option value="{{ $obj->id }}">{{ $obj->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Potencia promedio</label>
                                <select class="form-control" id="potencia_promedio">
                                    <option value="">No aplica</option>
                                </select>
                            </div>

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Potencia nominal</label>
                                <input type="number" step="0.001" name="potencia_nominal" id="potencia_nominal"
                                    value="{{ old('potencia_nominal') }}" required class="form-control">
                            </div>

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Consumo mensual</label>
                                <input type="number" step="0.001"  name="consumo_mensual" id="consumo_mensual"
                                    value="{{ old('consumo_mensual') }}" required class="form-control">
                            </div>

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Desidad luminicia</label>
                                <input type="number" step="0.001" name="decidad_luminicia"
                                    value="{{ old('decidad_luminicia') }}" class="form-control">
                            </div>

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Fecha ultimo censo</label>
                                <input type="date" name="fecha_ultimo_censo" value="{{ old('fecha_ultimo_censo') }}"
                                    required class="form-control">
                            </div>

                        </div>
                        <div>&nbsp;</div>
                        <div style="text-align: right;">
                            <button type="submit" style="margin-right: 18px" class="btn btn-dark">Aceptar</button>
                        </div>
                    </form>


                </div>






            </div>
        </div>
    </div>

    <!-- scripts -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            obtenerUbicacion();
            $("#departamento").change(function() {
                // var para la Departamento
                const Departamento = $(this).val();


                $.get("{{ url('censo_luminaria/get_distritos') }}" + '/' + Departamento, function(data) {
                    console.log(data);
                    var _select = ''
                    for (var i = 0; i < data.length; i++)
                        _select += '<option value="' + data[i].id + '">' + data[i].nombre +
                        '</option>';
                    $("#distrito").html(_select);

                });
            });


           /* $("#municipio").change(function() {
                var Municipio = $(this).val();
                $.get("{{ url('censo_luminaria/get_distritos') }}" + '/' + Municipio, function(data) {
                    var _select = ''
                    for (var i = 0; i < data.length; i++)
                        _select += '<option value="' + data[i].id + '"  >' + data[i].nombre +
                        '</option>';

                    $("#distrito").html(_select);
                });
            });*/

            $("#tipo_luminaria").change(function() {
                var tipo_luminaria = $(this).val();
                $.get("{{ url('censo_luminaria/get_potencia_promedio') }}" + '/' + tipo_luminaria,
                    function(data) {
                        if (data.length === 0) {
                            var _select = '<option value="">No aplica</option>';
                            $("#potencia_nominal").prop("disabled", false);
                        } else {
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
                    $("#potencia_nominal").prop("disabled", true);

                } else {
                    $.get("{{ url('censo_luminaria/get_consumo_mensual') }}" + '/' + potencia_promedio,
                        function(data) {
                            if (data.length === 0) {
                                document.getElementById('consumo_mensual').value = "";
                                $("#potencia_nominal").prop("disabled", false);
                            } else {
                                document.getElementById('consumo_mensual').value = data
                                    .consumo_promedio;
                                $("#potencia_nominal").prop("disabled", true);
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



        });

        function obtenerUbicacion() {
            // Mostrar la imagen de carga
            toggleLoading(true);

            // Verificar si el navegador soporta la geolocalización
            if (navigator.geolocation) {
                // Obtener la ubicación actual
                navigator.geolocation.getCurrentPosition(function(position) {
                    // Extraer latitud y longitud
                    var latitud = position.coords.latitude;
                    var longitud = position.coords.longitude;

                    // Mostrar latitud y longitud en los campos de texto
                    $("#latitud").val(latitud);
                    $("#longitud").val(longitud);
                    $("#localizacion").val(latitud+ ' '+longitud);

                     // Ocultar la imagen de carga
                     toggleLoading(false);
                });
            } else {
                alert("Tu navegador no soporta la geolocalización.");
                    // Ocultar la imagen de carga en caso de error
                    toggleLoading(false);
            }
        }

        function toggleLoading(show) {
                if (show) {
                    $("#loading").show();
                } else {
                    $("#loading").hide();
                }
            }
    </script> --}}
