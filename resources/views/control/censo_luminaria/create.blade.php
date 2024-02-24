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
                                        Modificar punto
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
                    @if ($puntosCercanos > 0)
                        <div class="alert alert-warning">
                            <p style="font-size: 16px"><iconify-icon icon="ph:warning-fill" width="24"
                                    height="24"></iconify-icon> Existen puntos cercanos ya registrados. Por favor
                                verifica</p>
                        </div>
                        <br>
                    @endif
                    <form method="POST" action="{{ url('control/censo_luminaria') }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-7">



                            <input type="hidden" name="latitud" value="{{ $latitude }}" class="form-control">
                            <input type="hidden" name="longitud" value="{{ $longitude }}" class="form-control">


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
                                <label for="largeInput" class="form-label">Municipio</label>
                                <select class="form-control" id="municipio">
                                    @foreach ($municipios as $obj)
                                        <option value="{{ $obj->id }}"
                                            {{ $municipio_id == $obj->id ? 'selected' : '' }}>{{ $obj->nombre }}
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
                                <textarea name="direccion" class="form-control" maxlength="500">{{ $direccion }}</textarea>
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
                                    <option value="">Favor ingresar la potencial Nominal</option>
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

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Observación <span id="number_text">(0/500)</span></label>
                                <textarea name="observacion" id="observacion" class="form-control" maxlength="500">{{ old('observacion') }}</textarea>
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


                $.get("{{ url('censo_luminaria/get_municipios') }}" + '/' + Departamento, function(data) {
                    console.log(data);
                    var _select = ''
                    for (var i = 0; i < data.length; i++)
                        _select += '<option value="' + data[i].id + '">' + data[i].nombre +
                        '</option>';
                    $("#municipio").html(_select);

                });
            });


            $("#municipio").change(function() {
                var Municipio = $(this).val();
                $.get("{{ url('censo_luminaria/get_distritos') }}" + '/' + Municipio, function(data) {
                    var _select = ''
                    for (var i = 0; i < data.length; i++)
                        _select += '<option value="' + data[i].id + '"  >' + data[i].nombre +
                        '</option>';

                    $("#distrito").html(_select);
                });
            });

            $("#tipo_luminaria").change(function() {
                var tipo_luminaria = $(this).val();
                $.get("{{ url('censo_luminaria/get_potencia_promedio') }}" + '/' + tipo_luminaria,
                    function(data) {
                        if (data.length === 0) {
                            var _select =
                                '<option value="">Favor ingresar la potencial Nominal</option>';
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

            $("#observacion").keyup(function() {
                var numCaracteres = $(this).val().length;
                $("#number_text").text("(" + numCaracteres + "/500)");
            });

        });
    </script>






@endsection
