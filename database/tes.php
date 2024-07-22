<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Mapbox Reverse Geocoding</title>
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css' rel='stylesheet' />
    <style>
        body { margin: 0; padding: 0; }
        #map { position: absolute; top: 0; bottom: 0; width: 100%; }
    </style>
</head>
<body>
    <p>ulla</p>
    <div id='map'></div>
    <script>
        mapboxgl.accessToken = 'pk.eyJ1IjoiZmFkbHVsbGFoeCIsImEiOiJjbHI0bmZrejcxYmx0MmpudjVkMzRjbm43In0.O_h7GYI9fXaoHr9XnIN5sg';
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [106.827153, -6.175110], // Koordinat awal
            zoom: 12
        });

        // Tambahkan marker pada klik peta
        map.on('click', function(e) {
            var lngLat = e.lngLat;
            var marker = new mapboxgl.Marker()
                .setLngLat(lngLat)
                .addTo(map);

            // Panggil reverse geocoding API
            var url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${lngLat.lng},${lngLat.lat}.json?access_token=${mapboxgl.accessToken}`;
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    var address = data.features[0].place_name;
                    console.log(`Alamat: ${address}`);

                    // Kirim data ke server untuk disimpan di database
                    saveLocationToDatabase(lngLat.lng, lngLat.lat, address);
                });
        });

        // Fungsi untuk mengirim data ke server
        function saveLocationToDatabase(lng, lat, address) {
            fetch('/save-location', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    longitude: lng,
                    latitude: lat,
                    address: address
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Data berhasil disimpan:', data);
            })
            .catch(error => {
                console.error('Error menyimpan data:', error);
            });
        }
    </script>
</body>
</html>
