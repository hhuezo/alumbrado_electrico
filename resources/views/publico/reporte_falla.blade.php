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

    <style>
        #map {
            height: 500px;
            width: 100%;
        }

        .card-title {
            text-transform: none;
        }
    </style>
</head>

<body>

    <div class="content-wrapper transition-all duration-150" id="content_wrapper">
        <div class="page-content">
            <div class="transition-all duration-150 container-fluid" id="page_layout">



                <div class="page-content">
                    <div class="transition-all duration-150 container-fluid" id="page_layout">
                        <div id="content_layout">
                            <div class="2xl:col-span-6 lg:col-span-6 col-span-12">
                                <div class="card">
                                    <div class="card-body p-6" id="div-map">
                                        <header
                                            class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                                            <div class="flex-1">
                                                <div class="card-title text-slate-900 dark:text-white">
                                                    <h5>Ubicacion de punto</h5>
                                                </div>
                                            </div>

                                            <a href="{{ URL('/home') }}">
                                                <button class="btn btn-dark btn-sm float-right">
                                                    <iconify-icon icon="icon-park-solid:back" style="color: white;"
                                                        width="24"></iconify-icon>
                                                </button>
                                            </a>
                                        </header>
                                        <div id="map"></div>
                                        <br>
                                        <div style="text-align: right;">
                                            <button type="button" onclick="showForm()" style="margin-right: 18px"
                                                class="btn btn-dark">Aceptar</button>
                                        </div>
                                    </div>




                                    <div class="card-body p-6" id="div-form" style="display: none">

                                        <header
                                            class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                                            <div class="flex-1">
                                                <div class="card-title text-slate-900 dark:text-white">
                                                    <h5>Reporte de falla</h5>
                                                </div>
                                            </div>


                                            <button type="button" class="btn btn-dark btn-sm float-right"
                                                onclick="showMap()">
                                                <iconify-icon icon="icon-park-solid:back" style="color: white;"
                                                    width="24"></iconify-icon>
                                            </button>

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

                                        <form method="POST" action="{{ url('publico/reporte_falla_publico') }}"
                                            enctype="multipart/form-data">
                                            @csrf

                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-7">
                                                <input type="hidden" id="latitud" name="latitud"
                                                    class="form-control">
                                                <input type="hidden" id="longitud" name="longitud"
                                                    class="form-control">
                                                <input type="hidden" id="distrito_get_id" class="form-control">


                                                <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">Fecha</label>
                                                    <input type="date" readonly name="fecha"
                                                        value="{{ date('Y-m-d') }}" required class="form-control">
                                                </div>

                                                <div class="input-area">
                                                    <label for="largeInput" class="form-label">Departamento</label>
                                                    <select class="form-control" id="departamento"
                                                        onchange="getDistrito(this.value)" name="departamento_id">
                                                        <option value="">Seleccione</option>
                                                        @foreach ($departamentos as $obj)
                                                            <option value="{{ $obj->id }}"
                                                                {{ old('departamento_id') == $obj->id ? 'selected' : '' }}>
                                                                {{ $obj->nombre }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="input-area">
                                                    <label for="largeInput" class="form-label">Distrito</label>
                                                    <select class="form-control" required name="distrito_id"
                                                        id="distrito">
                                                    </select>
                                                </div>


                                                <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">Tipo falla</label>
                                                    <select name="tipo_falla_id" class="form-control" required>
                                                        @foreach ($tipos as $obj)
                                                            <option value="{{ $obj->id }}">
                                                                {{ $obj->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">Descripción</label>
                                                    <input type="text" name="descripcion"
                                                        value="{{ old('descripcion') }}" required
                                                        class="form-control">
                                                </div>


                                                <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">Nombre</label>
                                                    <input type="text" name="nombre_contacto"
                                                        value="{{ old('nombre_contacto') }}" required
                                                        class="form-control">
                                                </div>

                                                <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">Telefono</label>
                                                    <input type="text" name="telefono_contacto"
                                                        value="{{ old('telefono_contacto') }}"
                                                        data-inputmask="'mask': ['9999-9999']" class="form-control">
                                                </div>


                                                <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">Fotografia</label>
                                                    <input type="file" name="archivo"
                                                        value="{{ old('archivo') }}" class="form-control">
                                                </div>


                                            </div>
                                            <br>
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




    <script>
        let map;
        let marker;

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: 0,
                    lng: 0
                },
                zoom: 15
            });

            // Obtener la ubicación actual
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };

                        map.setCenter(pos);
                        placeMarker(pos);
                        updateCoordinatesInput(pos.lat, pos.lng);
                    },
                    function() {
                        handleLocationError(true, map.getCenter());
                    }
                );
            } else {
                // El navegador no soporta la geolocalización
                handleLocationError(false, map.getCenter());
            }

            // Evento click en el mapa para cambiar el marcador y obtener latitud y longitud
            map.addListener('click', function(event) {
                const clickedLocation = event.latLng;
                placeMarker(clickedLocation);
                //showCoordinates(clickedLocation);
                updateCoordinatesInput(clickedLocation.lat(), clickedLocation.lng());
            });
        }

        function placeMarker(location) {
            if (marker) {
                marker.setPosition(location);
            } else {
                marker = new google.maps.Marker({
                    position: location,
                    map: map
                });
            }
        }

        function showCoordinates(location) {
            const coordinatesDiv = document.getElementById('coordinates');
            coordinatesDiv.textContent = `Latitud: ${location.lat().toFixed(6)}, Longitud: ${location.lng().toFixed(6)}`;
        }

        function updateCoordinatesInput(lat, lng) {
            document.getElementById('latitud').value = lat.toFixed(11);
            document.getElementById('longitud').value = lng.toFixed(11);
            obtenerUbicacion(lat.toFixed(11), lng.toFixed(11))
        }

        function handleLocationError(browserHasGeolocation, pos) {
            const infoWindow = new google.maps.InfoWindow();
            infoWindow.setPosition(pos);
            infoWindow.setContent(browserHasGeolocation ?
                'Error: La geolocalización ha fallado.' :
                'Error: Tu navegador no soporta la geolocalización.');
            infoWindow.open(map);
        }


        function obtenerUbicacion(latitud, longitud) {
            var url = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${latitud}&lon=${longitud}`;

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    //console.log(data);
                    if (data.address) {
                        var departamento = data.address.state;
                        var municipio = data.address.city || data.address.town || data.address.village || data
                            .address.county;

                        //console.log(departamento);
                        //console.log(municipio);
                        getDepartamento(departamento);
                        if (municipio != undefined) {
                            getDistritoId(municipio);
                        }

                    } else {
                        console.log("No se pudo obtener la información de ubicación.")
                    }
                },
                error: function() {
                    console.log("No se pudo obtener la información de ubicación.")
                }
            });
        }





        function getDepartamento(nombre) {
            var baseUrl = "{{ url('/catalogo/reporte_falla/get_departamento_id') }}";
            var urlCompleta = baseUrl + '/' + nombre;

            $.ajax({
                url: urlCompleta,
                type: 'GET',
                success: function(data) {
                    if (data != 0) {
                        document.getElementById('departamento').value = data;
                        getDistrito(data);
                    }
                },
                error: function() {
                    console.log("No se pudo obtener la información de ubicación.")
                }
            });
        }

        function getDistritoId(nombre) {
            var baseUrl = "{{ url('/catalogo/reporte_falla/get_distrito_id') }}";
            var urlCompleta = baseUrl + '/' + nombre;

            $.ajax({
                url: urlCompleta,
                type: 'GET',
                success: function(data) {
                    console.log("municipio: ", data);
                    document.getElementById('distrito_get_id').value = data;

                },
                error: function() {
                    console.log("No se pudo obtener la información de ubicación.")
                }
            });
        }
    </script>

    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script>
        function showForm() {
            $("#div-map").hide();
            $("#div-form").show();
        }

        function showMap() {
            $("#div-map").show();
            $("#div-form").hide();
        }

        function getDistrito(id) {

            $.get("{{ url('publico/reporte_falla_publico/get_distritos') }}" + '/' + id,
                function(data) {
                    //console.log(data);
                    var distrito_get_id = document.getElementById('distrito_get_id').value;
                    var _select = '';
                    for (var i = 0; i < data.length; i++) {
                        if (distrito_get_id == data[i].id) {
                            _select += '<option value="' + data[i].id + '" selected>' + data[i].nombre + '</option>';
                        } else {
                            _select += '<option value="' + data[i].id + '">' + data[i].nombre + '</option>';
                        }
                    }
                    $("#distrito").html(_select);
                });
        }
    </script>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js'></script>
    <script>
        $(document).ready(function() {
            $(":input").inputmask();
        });
    </script>



    <!-- Incluir la API de Google Maps -->
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key={{ $configuracion->api_key_maps }}&amp;callback=initMap"></script>


    <div id="coordinates"></div>

</body>
<script src="{{ asset('assets/js/iconify.js') }}"></script>
<script src="{{ asset('assets/js/rt-plugins.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>

</html>
