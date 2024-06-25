<style>
    #map {
        height: 100%;
        width: 100%;
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
        padding: 10px;
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
<script src="{{ asset('assets/js/iconify-icon.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<form id="form_map" method="GET" action="{{ url('reporte_falla/registrar_falla') }}">

    <input type="hidden" name="id" value="{{ $reporte_falla->id }}">
    <input type="hidden" id="latitude" name="latitude" value="{{ $reporte_falla->latitud }}">
    <input type="hidden" id="longitude" name="longitude" value="{{ $reporte_falla->longitud }}">
    <input type="hidden" name="censo_id" id="censo_id">
    <div id="map"></div>
    <button id="floating-button" type="button" onclick="sendData()">Aceptar Ubicación</button>
    <a href="{{ url('reporte_falla/') }}">
        <button id="back-button" type="button">
            <iconify-icon icon="icon-park-solid:back" style="color: white;" width="25">
            </iconify-icon>
        </button>
    </a>
</form>

<script>
    function initMap() {
        var latitudeInput = document.getElementById('latitude');
        var longitudeInput = document.getElementById('longitude');

        var sanSalvadorCenter = {
            lat: parseFloat(latitudeInput.value),
            lng: parseFloat(longitudeInput.value)
        }; // Coordenadas de los inputs
        var map = new google.maps.Map(document.getElementById('map'), {
            center: sanSalvadorCenter,
            zoom: 40
        });

        // Añadir marcador en la ubicación de los inputs (punto principal) con el icono predeterminado
        var mainMarker = new google.maps.Marker({
            position: sanSalvadorCenter,
            map: map,
            title: 'Punto Principal',
            draggable: false,
            zIndex: 1 // zIndex menor para que esté debajo de los marcadores secundarios
        });

        var points = {!! json_encode($points) !!};

        // Lista para guardar los marcadores
        var markers = [];

        // Iterar sobre los puntos y añadir marcadores al mapa con un icono diferente
        points.forEach(function(point) {
            var marker = new google.maps.Marker({
                position: {
                    lat: point.lat,
                    lng: point.lng
                },
                map: map,
                title: point.title,
                draggable: false,
                icon: {
                    url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png" // Icono azul
                },
                zIndex: 2 // zIndex mayor para que esté encima del marcador principal
            });

            // Añadir el marcador a la lista de marcadores
            markers.push(marker);

            // Añadir listener para el evento click en cada marcador
            marker.addListener('click', function() {
                // Restablecer el ícono de todos los marcadores al color original
                markers.forEach(function(m) {
                    m.setIcon("http://maps.google.com/mapfiles/ms/icons/blue-dot.png");
                });

                // Cambiar el ícono del marcador clicado al color verde
                marker.setIcon("http://maps.google.com/mapfiles/ms/icons/green-dot.png");

                document.getElementById('censo_id').value = point.id;
                console.log('ID del punto:', point.id);
            });
        });
    }


    function sendData() {
        var lat = document.getElementById('latitude').value;
        var lng = document.getElementById('longitude').value;
        var censo_id = document.getElementById('censo_id').value;
        if (!lat || !lng || !censo_id) {
            Swal.fire({
                title: 'Error!',
                text: 'La ubicación no es válida.',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
            return false;
        } else {
            document.getElementById('form_map').submit();
        }
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key={{ $configuracion->api_key_maps }}&callback=initMap" async
    defer></script>
