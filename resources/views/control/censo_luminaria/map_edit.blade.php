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

<form id="form_map" method="GET" action="{{ url('control/censo_luminaria/edit_censo') }}">
    <input type="hidden" id="id" name="id" value="{{$censo->id}}">
    <input type="hidden" id="latitude" name="latitude" value="{{$censo->latitud}}">
    <input type="hidden" id="longitude" name="longitude" value="{{$censo->longitud}}">
    <div id="map"></div>
    <button id="floating-button" type="button" onclick="sendData()">Aceptar Ubicación</button>
    <a href="{{ url('control/censo_luminaria/') }}">
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

        var initialPos = {
            lat: parseFloat(latitudeInput.value) || 0, // Default to 0 if value is not a valid number
            lng: parseFloat(longitudeInput.value) || 0  // Default to 0 if value is not a valid number
        };

        var map = new google.maps.Map(document.getElementById('map'), {
            center: initialPos,
            zoom: 15
        });

        var marker = new google.maps.Marker({
            position: initialPos,
            map: map,
            title: 'Tu ubicación actual',
            draggable: true
        });

        map.addListener('click', function(e) {
            marker.setPosition(e.latLng);
            latitudeInput.value = e.latLng.lat();
            longitudeInput.value = e.latLng.lng();
        });

        marker.addListener('dragend', function(e) {
            latitudeInput.value = e.latLng.lat();
            longitudeInput.value = e.latLng.lng();
        });
    }

    function handleLocationError(browserHasGeolocation, pos) {
        console.log(browserHasGeolocation ?
            'Error: El servicio de Geolocalización ha fallado.' :
            'Error: Tu navegador no soporta geolocalización.');
    }

    function sendData() {
        var lat = document.getElementById('latitude').value;
        var lng = document.getElementById('longitude').value;

        if (!lat || !lng) {
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
<script src="https://maps.googleapis.com/maps/api/js?key={{ $configuracion->api_key_maps }}&callback=initMap" async defer></script>
