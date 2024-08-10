<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DGEHM</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ $configuracion->api_key_maps }}&callback=initMap" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        #map {
            height: 100vh;
            width: 100%;
            position: relative;
        }

        #floating-button {
            position: absolute;
            bottom: 20px;
            right: 20px;
            padding: 15px 30px;
            font-size: 18px;
            background-color: #0F172A;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            z-index: 1000;
        }

        #back-button {
            position: absolute;
            top: 30px;
            right: 20px;
            padding: 10px;
            font-size: 18px;
            background-color: #0F172A;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <!-- Button to open the modal -->
    <button type="button" id="floating-button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Filtrar
    </button>

    <!-- Indicador de carga -->
<div id="loading" style="display: none;">
    <p>Cargando mapa...</p>
</div>

    <!-- Map container -->
    <div id="map"></div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="basic_modal_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="basic_modal_label">Filtrar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="GET" action="{{ url('importacion/base_datos/1') }}">
                    <div class="modal-body">
                        <div class="input-area">
                            <label for="largeInput" class="form-label">Departamento</label>
                            <select class="form-control" name="departamento_id" id="departamento">
                                <option value="">SELECCIONE</option>
                                @foreach ($departamentos as $obj)
                                    <option value="{{ $obj->id }}" {{$departamento_id == $obj->id ? 'selected':''}}>
                                         {{ $obj->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-area">
                            <label for="largeInput" class="form-label">Municipio</label>
                            <select class="form-control" name="municipio_id" id="municipio">
                                @if ($municipios)
                                    @foreach ($municipios as $obj)
                                        <option value="{{ $obj->id }}" {{$municipio_id == $obj->id ? 'selected':''}}>
                                             {{ $obj->nombre }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="input-area">
                            <label for="largeInput" class="form-label">Distrito</label>
                            <select class="form-control" name="distrito_id" id="distrito" required>
                                @if ($distritos)
                                @foreach ($distritos as $obj)
                                    <option value="{{ $obj->id }}" {{$distrito_id == $obj->id ? 'selected':''}}>
                                        {{ $obj->nombre }}
                                    </option>
                                @endforeach
                            @endif
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary">Aceptar</button>
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
                    var _select = '<option value="">SELECCIONE</option>'
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

        });
    </script>

    <!-- Google Maps Script -->
    <script>
        var map;
        var markers = @json($array_data);

        console.log("marcadores", markers);

        function initMap() {
            // Configurar el centro del mapa y la posición de inicio
            var centerPosition = { lat: 13.6929, lng: -89.2182 };

            if (markers.length > 0) {
                centerPosition = markers[0]; // Establecer el centro del mapa al primer marcador si hay datos
            }

            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 13,
                center: centerPosition
            });

            addMarkers(markers);
        }

        function addMarkers(markers) {
            for (let i = 0; i < markers.length; i++) {

                let marker = new google.maps.Marker({
                    position: markers[i],
                    map: map,
                    icon: {
                        url: "{{ asset('img/') }}/" + markers[i].icono,
                        scaledSize: new google.maps.Size(45, 45)
                    }
                });

                console.log("marcador" + i, marker);

                let infowindow = new google.maps.InfoWindow({
                    content: markers[i].shortDescription,
                    maxWidth: 1000
                });

                marker.addListener('mouseover', function() {
                    infowindow.open(map, marker);
                });

                marker.addListener('mouseout', function() {
                    infowindow.close();
                });
            }
        }
    </script>
</body>
</html>
