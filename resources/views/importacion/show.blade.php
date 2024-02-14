<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ $configuracion->api_key_maps }}&callback=initMap" async
    defer></script>

<style>
    #map {
        height: 100%;
        width: 100%;
    }
</style>

<div id="map"></div>
<script>
    var map;
    var markers = @json($array_data);

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 13,
            center: markers[0]
        });

        for (let i = 0; i < markers.length; i++) {
            let marker = new google.maps.Marker({
                position: markers[i],
                map: map,
                icon: {
                    url: "{{ asset('img/') }}/" + markers[i].icono,
                    scaledSize: new google.maps.Size(45, 45)
                }
            });

            let infowindow = new google.maps.InfoWindow({
                content: markers[i].shortDescription,
                maxWidth: 1000 // Ajusta el tamaño según tus necesidades
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





@php

    //[{"lat":13.76631,"lng":-88.5522,"description":6358},{"lat":13.846847,"lng":-88.865118,"description":6358},{"lat":13.751876,"lng":-89.194102,"description":6358},{"lat":13.848951,"lng":-89.343298,"description":2455}];
@endphp
