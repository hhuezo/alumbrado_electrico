@extends ('menu')
@section('contenido')
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
                    <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                        <div class="flex-1">
                            <div class="card-title text-slate-900 dark:text-white">Reporte falla

                                <a href="{{ url('catalogo/reporte_falla') }}">
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
                                        <form method="POST" action="{{ url('catalogo/reporte_falla') }}"
                                            enctype="multipart/form-data">
                                            @csrf

                                            <div id="loading">
                                                <img src="{{ asset('img/loading.gif') }}" style="width: 100px; height:100px"
                                                    alt="Cargando...">
                                            </div>

                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-7">
                                                <input type="hidden" id="latitud" name="latitud" class="form-control">
                                                <input type="hidden" id="longitud"  name="longitud" class="form-control">

                                                <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">Localización</label>
                                                    <div class="relative">
                                                        <input type="text" id="localizacion" required class="form-control !pr-12"
                                                            readonly>
                                                        <button onclick="obtenerUbicacion()" type="button"
                                                            class="absolute btn-dark right-0 top-1/2 -translate-y-1/2 w-9 h-full border-l border-l-slate-200 dark:border-l-slate-700 flex items-center justify-center">
                                                            <iconify-icon icon="mdi:location" style="color: white;"
                                                                width="24"></iconify-icon>
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">Fecha</label>
                                                    <input type="date" name="fecha" value="{{ old('fecha') }}"
                                                        required class="form-control">
                                                </div>

                                                <div class="input-area">
                                                    <label for="largeInput" class="form-label">Departamento</label>
                                                    <select class="form-control" id="departamento" name="departamento_id">
                                                        <option value="">Seleccione</option>
                                                        @foreach ($departamentos as $obj)
                                                            <option value="{{ $obj->id }}" {{old('departamento_id') == $obj->id ? 'selected':''}}>{{ $obj->nombre }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="input-area">
                                                    <label for="largeInput" class="form-label">Distrito</label>
                                                    <select class="form-control" required name="distrito_id" id="distrito">
                                                    </select>
                                                </div>


                                                <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">Tipo falla</label>
                                                    <select name="tipo_falla_id" class="form-control" required>
                                                        @foreach ($tipos as $obj)
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
                                                    <input type="text" name="nombre_contacto" value="{{ old('nombre_contacto') }}"
                                                        required class="form-control">
                                                </div>

                                                <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">Telefono</label>
                                                    <input type="text" name="telefono_contacto" value="{{ old('telefono_contacto') }}" data-inputmask="'mask': ['9999-9999']" class="form-control">
                                                </div>


                                                <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">Fotografia</label>
                                                    <input type="file" name="archivo" value="{{ old('archivo') }}" class="form-control">
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


                $.get("{{ url('censo_luminaria/get_distritos') }}" + '/' + Departamento, function(data) {
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

@endsection
