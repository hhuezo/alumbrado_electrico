@extends('menu')
@section('contenido')
    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])





    <div class="content-wrapper transition-all duration-150 " id="content_wrapper">
        <div class="page-content">
            <div class="transition-all duration-150 container-fluid" id="page_layout">
                <div id="content_layout">

                    <div class="grid grid-cols-1 gap-6">

                        <div class="card">
                            <div class="card-body flex flex-col p-6">
                                <header
                                    class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6 card-header">
                                    <div class="flex-1">
                                        <div class="card-title text-slate-900 dark:text-white">Censo
                                            {{ $censo->codigo_luminaria }}
                                            <a href="{{ url('control/censo_luminaria') }}">
                                                <button class="btn btn-dark btn-sm float-right">
                                                    <iconify-icon icon="icon-park-solid:back" style="color: white;"
                                                        width="18">
                                                    </iconify-icon>
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </header>
                                <div class="card-text h-full ">
                                    <div class="active">
                                        <ul class="nav nav-tabs flex flex-col md:flex-row flex-wrap list-none border-b-0 pl-0 mb-4 menu-open"
                                            id="tabs-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a href="#tabs-home"
                                                    class="nav-link w-full block font-medium text-sm font-Inter leading-tight capitalize border-x-0 border-t-0 border-b border-transparent px-4 pb-2 my-2 hover:border-transparent focus:border-transparent dark:text-slate-300 active"
                                                    id="tabs-home-tab" data-bs-toggle="pill" data-bs-target="#tabs-home"
                                                    role="tab" aria-controls="tabs-home" aria-selected="true">Censo</a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a href="#tabs-profile"
                                                    class="nav-link w-full block font-medium text-sm font-Inter leading-tight capitalize border-x-0 border-t-0 border-b border-transparent px-4 pb-2 my-2 hover:border-transparent focus:border-transparent dark:text-slate-300"
                                                    id="tabs-profile-tab" data-bs-toggle="pill"
                                                    data-bs-target="#tabs-profile" role="tab"
                                                    aria-controls="tabs-profile" aria-selected="false">Linea de tiempo</a>
                                            </li>

                                        </ul>
                                        <div class="tab-content" id="tabs-tabContent">
                                            <div class="tab-pane fade active show" id="tabs-home" role="tabpanel"
                                                aria-labelledby="tabs-home-tab">
                                                @if (count($errors) > 0)
                                                    <div class="alert alert-danger">
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                                <form method="POST"
                                                    action="{{ url('control/censo_luminaria/create_record') }}">
                                                    @csrf
                                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-7">

                                                        <input type="hidden" name="codigo_luminaria"
                                                            value="{{ $censo->codigo_luminaria }}" required
                                                            class="form-control">
                                                            <input type="hidden" name="latitud" value="{{ $censo->latitud }}" class="form-control">
                                                            <input type="hidden" name="longitud" value="{{ $censo->longitud }}" class="form-control">

                                                        <div class="input-area">
                                                            <label for="largeInput" class="form-label">Departamento</label>
                                                            <select class="form-control" id="departamento" readonly>
                                                                @foreach ($departamentos as $obj)
                                                                    <option value="{{ $obj->id }}"
                                                                        {{ $censo->distrito->municipio->departamento_id == $obj->id ? 'selected' : '' }}>
                                                                        {{ $obj->nombre }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="input-area">
                                                            <label for="largeInput" class="form-label">Municipio</label>
                                                            <select class="form-control" id="departamento" readonly>
                                                                @foreach ($municipios as $obj)
                                                                    <option value="{{ $obj->id }}"
                                                                        {{ $censo->distrito->municipio_id == $obj->id ? 'selected' : '' }}>
                                                                        {{ $obj->nombre }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="input-area">
                                                            <label for="largeInput" class="form-label">Distrito</label>
                                                            <select class="form-control" name="distrito_id" id="distrito"
                                                                readonly>
                                                                @foreach ($distritos as $obj)
                                                                    <option value="{{ $obj->id }}"
                                                                        {{ $censo->distrito_id == $obj->id ? 'selected' : '' }}>
                                                                        {{ $obj->nombre }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="input-area">
                                                            <label for="largeInput" class="form-label">Dirección</label>
                                                            <textarea name="direccion" class="form-control" maxlength="500" readonly>{{ $censo->direccion }}</textarea>
                                                        </div>

                                                        {{--  <div class="input-area">
                                                            <label for="largeInput" class="form-label">Codigo
                                                                luminaria</label>
                                                            <input type="text" name="codigo_luminaria"
                                                                value="{{ $censo->codigo_luminaria }}" required
                                                                class="form-control" readonly>

                                                        </div> --}}
                                                    </div>
                                                    <br>
                                                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-7">
                                                        <div class="input-area">
                                                            <label for="largeInput" class="form-label">Tipo
                                                                luminaria</label>
                                                            <select class="form-control" name="tipo_luminaria_id"
                                                                id="tipo_luminaria">
                                                                @foreach ($tipos as $obj)
                                                                    <option value="{{ $obj->id }}"
                                                                        {{ $censo->tipo_luminaria_id == $obj->id ? 'selected' : '' }}>
                                                                        {{ $obj->nombre }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="input-area" id="div_potencia_promedio"
                                                            style="display: {{$censo->tipo_luminaria->potenciaPromedio->count() == 0 ? 'none':'block'}}">

                                                            <label for="largeInput" class="form-label">Potencia
                                                                promedio  (Vatio)</label>
                                                            <select class="form-control" id="potencia_promedio">



                                                                @if ($potencias_promedio->count() > 0)
                                                                    @foreach ($potencias_promedio as $obj)
                                                                        <option value="{{ $obj->id }}"
                                                                            {{ $censo->tipo_luminaria_id == $obj->id ? 'selected' : '' }}>
                                                                            {{ $obj->potencia }}</option>
                                                                    @endforeach
                                                                @else
                                                                    <option value="">Favor ingresar la potencia Nominal</option>
                                                                @endif

                                                            </select>
                                                        </div>

                                                        <div class="input-area" id="div_potencia_nominal"  style="display: {{$censo->tipo_luminaria->potenciaPromedio->count() > 0 ? 'none':'block'}}">
                                                            <label for="largeInput" class="form-label">Favor ingresar la potencial Nominal (Vatio)</label>
                                                            <input type="number" step="0.001" name="potencia_nominal"
                                                                id="potencia_nominal"
                                                                value="{{ $censo->potencia_nominal }}"
                                                                class="form-control">
                                                        </div>

                                                        <div class="input-area">
                                                            <label for="largeInput" class="form-label">Consumo
                                                                mensual</label>
                                                            <input type="number" step="0.001" readonly
                                                                name="consumo_mensual" id="consumo_mensual"
                                                                value="{{ $censo->consumo_mensual }}" required
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-7">

                                                        <div class="input-area">
                                                            <label for="condicion_lampara" class="form-label">¿Está la lámpara en buenas
                                                                condiciones?</label>
                                                            <label class="switch">
                                                                <input type="checkbox" {{$censo->condicion_lampara == 1 ? 'checked':''}} id="condicion_lampara" name="condicion_lampara">
                                                                <span class="slider round"></span>

                                                                <span class="switch-label yes">&nbsp;Sí</span> <!-- Etiqueta para "Sí" -->
                                                                <span class="switch-label no">No</span> <!-- Etiqueta para "No" -->
                                                            </label>
                                                        </div>

                                                        <div class="input-area" id="div_tipo_falla" style="display: {{$censo->condicion_lampara == 1 ? 'none':'' }} " >
                                                            <label for="largeInput" class="form-label">Tipo falla</label>
                                                            <select class="form-control" name="tipo_falla_id" id="tipo_falla_id" required>
                                                                <option value="">Seleccione</option>
                                                                @foreach ($tipos_falla as $obj)
                                                                    <option value="{{ $obj->id }}" {{$censo->tipo_falla_id == $obj->id ? 'selected':''}}>{{ $obj->nombre }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>



                                                    </div>
                                                    <br>
                                                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-7">

                                                        <div class="input-area">
                                                            <label for="largeInput" class="form-label">Observación <span
                                                                id="number_text">({{strlen($censo->observacion)}}/500)</span></label>

                                                            <textarea name="observacion" id="observacion" class="form-control" maxlength="500">{{ $censo->observacion }}</textarea>
                                                        </div>

                                                        {{-- <div class="input-area">
                                                            <label for="largeInput" class="form-label">Fecha ultimo censo</label>
                                                            <input type="date" name="fecha_ultimo_censo" value="{{ old('fecha_ultimo_censo') }}"
                                                                class="form-control">
                                                        </div> --}}

                                                    </div>
                                                    <div>&nbsp;</div>
                                                    <div style="text-align: right;">
                                                        <button type="submit" style="margin-right: 18px"
                                                            class="btn btn-dark">Aceptar</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane fade" id="tabs-profile" role="tabpanel"
                                                aria-labelledby="tabs-profile-tab">



                                                <style>
                                                    /* The actual timeline (the vertical ruler) */
                                                    .main-timeline {
                                                        position: relative;
                                                    }

                                                    /* The actual timeline (the vertical ruler) */
                                                    .main-timeline::after {
                                                        content: "";
                                                        position: absolute;
                                                        width: 6px;
                                                        background-color: #939597;
                                                        top: 0;
                                                        bottom: 0;
                                                        left: 50%;
                                                        margin-left: -3px;
                                                    }

                                                    /* Container around content */
                                                    .timeline {
                                                        position: relative;
                                                        background-color: inherit;
                                                        width: 50%;
                                                    }

                                                    /* The circles on the timeline */
                                                    .timeline::after {
                                                        content: "";
                                                        position: absolute;
                                                        width: 25px;
                                                        height: 25px;
                                                        right: -13px;
                                                        background-color: #939597;
                                                        border: 5px solid #f5df4d;
                                                        top: 15px;
                                                        border-radius: 50%;
                                                        z-index: 1;
                                                    }

                                                    /* Place the container to the left */
                                                    .left {
                                                        padding: 0px 40px 20px 0px;
                                                        left: 0;
                                                    }

                                                    /* Place the container to the right */
                                                    .right {
                                                        padding: 0px 0px 20px 40px;
                                                        left: 50%;
                                                    }

                                                    /* Add arrows to the left container (pointing right) */
                                                    .left::before {
                                                        content: " ";
                                                        position: absolute;
                                                        top: 18px;
                                                        z-index: 1;
                                                        right: 30px;
                                                        border: medium solid white;
                                                        border-width: 10px 0 10px 10px;
                                                        border-color: transparent transparent transparent white;
                                                    }

                                                    /* Add arrows to the right container (pointing left) */
                                                    .right::before {
                                                        content: " ";
                                                        position: absolute;
                                                        top: 18px;
                                                        z-index: 1;
                                                        left: 30px;
                                                        border: medium solid white;
                                                        border-width: 10px 10px 10px 0;
                                                        border-color: transparent white transparent transparent;
                                                    }

                                                    /* Fix the circle for containers on the right side */
                                                    .right::after {
                                                        left: -12px;
                                                    }

                                                    /* Media queries - Responsive timeline on screens less than 600px wide */
                                                    @media screen and (max-width: 600px) {

                                                        /* Place the timelime to the left */
                                                        .main-timeline::after {
                                                            left: 31px;
                                                        }

                                                        /* Full-width containers */
                                                        .timeline {
                                                            width: 100%;
                                                            padding-left: 70px;
                                                            padding-right: 25px;
                                                        }

                                                        /* Make sure that all arrows are pointing leftwards */
                                                        .timeline::before {
                                                            left: 60px;
                                                            border: medium solid white;
                                                            border-width: 10px 10px 10px 0;
                                                            border-color: transparent white transparent transparent;
                                                        }

                                                        /* Make sure all circles are at the same spot */
                                                        .left::after,
                                                        .right::after {
                                                            left: 18px;
                                                        }

                                                        .left::before {
                                                            right: auto;
                                                        }

                                                        /* Make all right containers behave like the left ones */
                                                        .right {
                                                            left: 0%;
                                                        }
                                                    }
                                                </style>








                                                <section style="background-color: #F0F2F5;">
                                                    <div class="container py-5">
                                                        <div class="main-timeline">
                                                            @php($i = 1)
                                                            @foreach ($registros as $registro)
                                                                <div
                                                                    class="timeline {{ $i % 2 == 0 ? 'left' : 'right' }} ">
                                                                    <div class="card">
                                                                        <div class="card-body p-4">
                                                                            <h5>{{ date('d/m/Y', strtotime($registro->fecha_ingreso)) }}
                                                                            </h5>
                                                                            <p class="mb-0">TIPO LUMINARIA:
                                                                                <strong>{{ $registro->tipo_luminaria->nombre }}</strong>
                                                                            </p>
                                                                            <p class="mb-0">CONSUMO MENSUAL:
                                                                                <strong>{{ $registro->consumo_mensual }}
                                                                                    kWh</strong>
                                                                            </p>
                                                                            <p class="mb-0">OBSERVACIÓN:
                                                                                <strong>{{ $registro->observacion }}</strong>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @php($i++)
                                                            @endforeach


                                                        </div>
                                                    </div>
                                                </section>




                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>




    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            // $("#tipo_luminaria").change();


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

@endsection
