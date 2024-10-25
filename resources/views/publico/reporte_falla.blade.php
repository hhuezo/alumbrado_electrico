<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa con Ubicación Actual</title>

    <link rel="icon" type="image/png" href="assets/images/logo/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/rt-plugins.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <!-- START : Theme Config js-->
    <script src="{{ asset('assets/js/settings.js') }}" sync></script>
    <!-- END : Theme Config js-->

<body>

    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])

    <style>
        #loading {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
        }

        #loading img {
            width: 50px;
            /* ajusta el tamaño de la imagen según sea necesario */
            height: 50px;
        }
    </style>

    <div class="grid grid-cols-12 gap-5 mb-5">

        <div class="2xl:col-span-12 lg:col-span-12 col-span-12">
            <div class="card">
                <div class="card-body flex flex-col p-6">
                    <header
                        class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6 card-header">
                        <div class="flex-1">
                            <div class="card-title text-slate-900 dark:text-white">Reporte falla

                                <a href="{{ url('publico/reporte_falla_publico') }}">
                                    <button class="btn btn-dark btn-sm float-right">
                                        <iconify-icon icon="icon-park-solid:back" style="color: white;" width="18">
                                        </iconify-icon>
                                    </button>
                                </a>
                            </div>
                        </div>
                    </header>



                    <div class="transition-all duration-150 container-fluid" id="page_layout">
                        <div id="content_layout">
                            <div class="space-y-5">
                                <div class="grid grid-cols-12 gap-5">

                                    <div class="xl:col-span-12 col-span-12 lg:col-span-6">
                                        @if (count($errors) > 0)
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <form method="POST" action="{{ url('publico/reporte_falla_publico') }}"
                                            enctype="multipart/form-data">
                                            @csrf

                                            <div id="loading">
                                                <img src="{{ asset('img/loading.gif') }}"
                                                    style="width: 100px; height:100px" alt="Cargando...">
                                            </div>

                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-7">
                                                <input type="hidden" name="latitud" value="{{ $latitude }}"
                                                    class="form-control">
                                                <input type="hidden" name="longitud" value="{{ $longitude }}"
                                                    class="form-control">


                                                <div class="input-area">
                                                    <label for="largeInput" class="form-label">Departamento</label>
                                                    <select class="form-control" id="departamento">
                                                        @foreach ($departamentos as $obj)
                                                            <option value="{{ $obj->id }}"
                                                                {{ $id_departamento == $obj->id ? 'selected' : '' }}>
                                                                {{ $obj->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>


                                                <div class="input-area">
                                                    <label for="largeInput" class="form-label">Municipio</label>
                                                    <select class="form-control" id="municipio">
                                                        <option value="{{ $obj->id }}">SELECCIONE
                                                        </option>
                                                        @if ($municipios)
                                                            @foreach ($municipios as $obj)
                                                                @if ($municipio_id == null)

                                                                @endif
                                                                <option value="{{ $obj->id }}"
                                                                    {{ $municipio_id == $obj->id ? 'selected' : '' }}>
                                                                    {{ $obj->nombre }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>

                                                <div class="input-area">
                                                    <label for="largeInput" class="form-label">Distrito</label>
                                                    <select class="form-control" name="distrito_id" id="distrito"
                                                        required>
                                                        @if ($distritos)
                                                            @foreach ($distritos as $obj)
                                                                <option value="{{ $obj->id }}"
                                                                    {{ $id_distrito == $obj->id ? 'selected' : '' }}>
                                                                    {{ $obj->nombre }}</option>
                                                            @endforeach
                                                        @endif

                                                    </select>
                                                </div>


                                                <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">Tipo falla</label>
                                                    <select name="tipo_falla_id" class="form-control" required>
                                                        @foreach ($tipos_falla as $obj)
                                                            <option value="{{ $obj->id }}">{{ $obj->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">Descripción</label>
                                                    <input type="text" name="descripcion"
                                                        value="{{ old('descripcion') }}" required class="form-control">
                                                </div>


                                                <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">Nombre</label>
                                                    <input type="text" name="nombre_contacto" required
                                                        class="form-control">
                                                </div>

                                                <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">Correo</label>
                                                    <input type="text" name="correo_contacto" class="form-control">
                                                </div>

                                                <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">Telefono</label>
                                                    <input type="text" name="telefono_contacto" value=""
                                                        data-inputmask="'mask': ['9999-9999']" class="form-control">
                                                </div>


                                                <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">Fotografia</label>
                                                    <input type="file" name="archivo"
                                                        value="{{ old('archivo') }}" class="form-control">
                                                </div>


                                            </div>

                                            <div style="text-align: right;">
                                                <button type="submit" style="margin-right: 18px"
                                                    class="btn btn-dark">Aceptar</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>

                            </div>




                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- scripts -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js'></script>


    <script type="text/javascript">
        $(document).ready(function() {
            $(":input").inputmask();
            $("#departamento").change(function() {
                // var para la Departamento
                const Departamento = $(this).val();


                $.get("{{ url('publico/reporte_falla_publico/get_municipios') }}" + '/' + Departamento, function(data) {
                    console.log(data);
                    var _select = '<option value="">SELECCIONE</option>'
                    for (var i = 0; i < data.length; i++)
                        _select += '<option value="' + data[i].id + '">' + data[i].nombre +
                        '</option>';
                    $("#municipio").html(_select);

                });
            });

            $("#municipio").change(function() {
                // var para la Departamento
                const municipio = $(this).val();


                $.get("{{ url('publico/reporte_falla_publico/get_distritos') }}" + '/' + municipio, function(data) {
                    console.log(data);
                    var _select = ''
                    for (var i = 0; i < data.length; i++)
                        _select += '<option value="' + data[i].id + '">' + data[i].nombre +
                        '</option>';
                    $("#distrito").html(_select);

                });
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
                    $("#localizacion").val(latitud + ' ' + longitud);

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
    </script>












</body>
<script src="{{ asset('assets/js/iconify.js') }}"></script>
<script src="{{ asset('assets/js/rt-plugins.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>

</html>
