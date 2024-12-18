@extends('menu')
@section('contenido')
    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
    <div class="grid grid-cols-12 gap-5 mb-5">

        <div class="2xl:col-span-12 lg:col-span-12 col-span-12">
            <div class="card">
                <div class="card-body flex flex-col p-6">
                    <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6 card-header">
                        <div class="flex-1">
                            <div class="card-title text-slate-900 dark:text-white">Censo

                                <a href="{{ url('control/censo_luminaria') }}">
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
                    <form method="POST" action="{{ route('censo_luminaria.update', $censo->id) }}">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="latitud" value="{{ $latitude }}" class="form-control">
                        <input type="hidden" name="longitud" value="{{ $longitude }}" class="form-control">
                        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-7">

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Departamento</label>
                                <select class="form-control" id="departamento">
                                    @foreach ($departamentos as $obj)
                                        <option value="{{ $obj->id }}"
                                            {{ $censo->distrito->municipio->departamento_id == $obj->id ? 'selected' : '' }}>
                                            {{ $obj->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="input-area">
                                <label for="largeInput" class="form-label">Municipio</label>
                                <select class="form-control" name="municipio_id" id="municipio">
                                    @foreach ($municipios as $obj)
                                        <option value="{{ $obj->id }}"
                                            {{ $censo->distrito->municipio_id == $obj->id ? 'selected' : '' }}>
                                            {{ $obj->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Distrito</label>
                                <select class="form-control" name="distrito_id" id="distrito">
                                    @foreach ($distritos as $obj)
                                        <option value="{{ $obj->id }}"
                                            {{ $censo->distrito_id == $obj->id ? 'selected' : '' }}>{{ $obj->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <br>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-7">
                            <div class="input-area">
                                <label for="largeInput" class="form-label">Codigo luminaria</label>
                                <input type="text" name="codigo_luminaria" value="{{ $censo->codigo_luminaria }}"
                                    required class="form-control">

                            </div>


                            <div class="input-area">
                                <label for="largeInput" class="form-label">Dirección</label>
                                <textarea name="direccion" class="form-control" maxlength="500">{{ $censo->direccion }}</textarea>
                            </div>


                        </div>
                        <br>

                        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-7">

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Tipo luminaria</label>
                                <select class="form-control" name="tipo_luminaria_id" id="tipo_luminaria">
                                    @foreach ($tipos as $obj)
                                        <option value="{{ $obj->id }}"
                                            {{ $censo->tipo_luminaria_id == $obj->id ? 'selected' : '' }}>
                                            {{ $obj->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-area" id="div_potencia_promedio"
                                style="display: {{ $potencias_promedio->count() > 0 ? 'block' : 'none' }}">
                                <label for="largeInput" class="form-label">Potencia promedio (Vatio)
                                    {{ $censo->potencia_nominal }}</label>
                                <select class="form-control" name="potencia_promedio" id="potencia_promedio">
                                    <option value="">Seleccione</option>
                                    @if ($potencias_promedio->count() > 0)
                                        @foreach ($potencias_promedio as $obj)
                                            <option value="{{ $obj->potencia }}"
                                                {{ $censo->potencia_nominal == $obj->potencia ? 'selected' : '' }}>
                                                {{ $obj->potencia }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="input-area" id="div_potencia_nominal"
                                style="display: {{ $potencias_promedio->count() > 0 ? 'none' : 'block' }}">
                                <label for="largeInput" class="form-label">Favor ingresar la potencial Nominal
                                    (Vatio)</label>
                                <input type="number" step="0.001" name="potencia_nominal" id="potencia_nominal"
                                    value="{{ $censo->potencia_nominal }}" {{ $potencias_promedio->count() > 0 ? 'none' : 'required' }} class="form-control">
                            </div>

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Consumo mensual (kWh)</label>
                                <input type="number" step="0.001" name="consumo_mensual" id="consumo_mensual"
                                    value="{{ $censo->consumo_mensual }}" required class="form-control">
                            </div>
                        </div>
                        <br>


                        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-7">

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Compañia</label>
                                <select class="form-control" name="compania_id" id="compania" required>
                                    <option value="">Seleccione</option>
                                    @foreach ($companias as $obj)
                                        <option value="{{ $obj->id }}"
                                            {{ $censo->compania_id == $obj->id ? 'selected' : '' }}>{{ $obj->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-area">
                                <label for="condicion_lampara" class="form-label">¿Está la lámpara en buenas
                                    condiciones?</label>
                                <label class="switch">
                                    <input type="checkbox" {{ $censo->condicion_lampara == 1 ? 'checked' : '' }}
                                        id="condicion_lampara" name="condicion_lampara">
                                    <span class="slider round"></span>

                                    <span class="switch-label yes">&nbsp;Sí</span> <!-- Etiqueta para "Sí" -->
                                    <span class="switch-label no">No</span> <!-- Etiqueta para "No" -->
                                </label>
                            </div>

                            <div class="input-area" id="div_tipo_falla"
                                style="display: {{ $censo->condicion_lampara == 1 ? 'none' : 'block' }}">
                                <label for="largeInput" class="form-label">Tipo falla</label>
                                <select class="form-control" name="tipo_falla_id" id="tipo_falla_id" {{ $censo->condicion_lampara == 1 ?  : 'required' }}>
                                    <option value="">Seleccione</option>
                                    @foreach ($tipos_falla as $obj)
                                        <option value="{{ $obj->id }}"
                                            {{ $censo->tipo_falla_id == $obj->id ? 'selected' : '' }}>{{ $obj->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>



                        </div>
                        <div>&nbsp;</div>
                        <div class="input-area">
                            <label for="largeInput" class="form-label">Observación <span
                                    id="number_text">(0/500)</span></label>
                            <textarea name="observacion" id="observacion" class="form-control" maxlength="500">{{ $censo->observacion }}</textarea>
                        </div>
                        <div>&nbsp;</div>
                        <div style="text-align: right;">
                            <button type="submit" style="margin-right: 18px" class="btn btn-dark">Aceptar</button>
                        </div>

                    </form>


                </div>

            </div>




        </div>

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
                        var _select = '<option value="">SELECCIONE</option>'
                        for (var i = 0; i < data.length; i++)
                            _select += '<option value="' + data[i].id + '"  >' + data[i].nombre +
                            '</option>';

                        $("#distrito").html(_select);
                    });
                });

                $("#distrito").change(function() {
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
                });

            });
        </script>

        <script>
            function updateSwitchText(element) {
                var switchText = document.getElementById("switchText");
                switchText.innerText = element.checked ? "Sí" : "No";
            }
        </script>


    @endsection
