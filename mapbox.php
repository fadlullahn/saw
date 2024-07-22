<?php
include 'model_lokasi.php';
?>
<!DOCTYPE html>
<html>

<head>
    <style>
        #map {
            height: 550px;
            top: 20px;
            position: relative;
            width: 100%;
        }

        .geocoder {
            position: relative;
            margin-bottom: 20px;
        }

        .card-form {
            margin-top: 20px;
        }
    </style>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.48.0/mapbox-gl.css' rel='stylesheet' />
    <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v2.3.0/mapbox-gl-geocoder.css' type='text/css' />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form action="" id="signupForm" class="card-form">
                    <div class="card border-dark">
                        <div class="card-header bg-success text-white border-dark">
                            <strong>Input Data Lokasi</strong>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="latitude">Latitude</label>
                                <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Latitude.." required>
                            </div>
                            <div class="form-group">
                                <label for="longitude">Longitude</label>
                                <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Longitude.." required>
                            </div>
                            <div class="form-group">
                                <label for="lokasi">Nama Lokasi</label>
                                <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Nama Lokasi" required>
                            </div>
                            <input class="btn btn-success" type="submit" value="Simpan">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <div class="geocoder mt-4" id="geocoder"></div>
                <div id="map"></div>
            </div>
        </div>
    </div>

    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.48.0/mapbox-gl.js'></script>
    <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v2.3.0/mapbox-gl-geocoder.min.js'></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <script>
        var markers = <?= get_lokasi() ?>;
        var lokasi_parepare = [119.6290, -4.0099];

        mapboxgl.accessToken = 'pk.eyJ1IjoiZmFkbHVsbGFoeCIsImEiOiJjbHI0bmZrejcxYmx0MmpudjVkMzRjbm43In0.O_h7GYI9fXaoHr9XnIN5sg';
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v9',
            center: lokasi_parepare,
            zoom: 12
        });

        var geocoder = new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
        });

        var marker;

        map.on('load', function() {
            addMarker(lokasi_parepare, 'load');
            add_markers(markers);

            geocoder.on('result', function(ev) {
                alert("FIND");
                console.log(ev.result.center);
            });
        });

        map.on('click', function(e) {
            marker.remove();
            addMarker(e.lngLat, 'click');
            document.getElementById("latitude").value = e.lngLat.lat;
            document.getElementById("longitude").value = e.lngLat.lng;
        });

        function addMarker(ltlng, event) {
            if (event === 'click') {
                lokasi_parepare = ltlng;
            }
            marker = new mapboxgl.Marker({
                    draggable: true,
                    color: "#d02922"
                })
                .setLngLat(lokasi_parepare)
                .addTo(map)
                .on('dragend', onDragEnd);
        }

        function add_markers(coordinates) {
            var geojson = (markers == coordinates ? markers : '');
            geojson.forEach(function(marker) {
                new mapboxgl.Marker()
                    .setLngLat(marker)
                    .addTo(map);
            });
        }

        function onDragEnd() {
            var lngLat = marker.getLngLat();
            document.getElementById("latitude").value = lngLat.lat;
            document.getElementById("longitude").value = lngLat.lng;
            console.log('longitude: ' + lngLat.lng + '<br />latitude: ' + lngLat.lat);
        }

        $('#signupForm').submit(function(event) {
            event.preventDefault();

            var lat = $('#latitude').val();
            var lng = $('#longitude').val();
            var namaLokasi = $('#lokasi').val(); // Menambahkan pengambilan nilai 'lokasi'
            var url = 'model_lokasi.php?tambah_lokasi&latitude=' + lat + '&longitude=' + lng + '&nama=' + namaLokasi;

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    alert(data);
                    location.reload();
                }
            });
        });

        document.getElementById('geocoder').appendChild(geocoder.onAdd(map));
    </script>
</body>

</html>