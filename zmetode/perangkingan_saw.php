<?php
$u = 1;
$alternatives = array();
$sql_alternatives = 'SELECT * FROM pendaftaran';
$data_alternatives = $conn->query($sql_alternatives);
while ($row_alternatives = $data_alternatives->fetch_object()) {
    $alternatives[$row_alternatives->iddaftar] = $row_alternatives->name;
}
?>

<?php
$criteria_data = array();
$bobot = array();
$sql_criteria = 'SELECT * FROM kriteria WHERE metode = "SAW"';
$data_criteria = $conn->query($sql_criteria);
while ($row_criteria = $data_criteria->fetch_object()) {
    $criteria_data[$row_criteria->idk] = array($row_criteria->nama_k, $row_criteria->jenis_k);
    $bobot[$row_criteria->idk] = $row_criteria->bobot;
}
?>

<?php
$decision_matrix = array();
$sql_decision_matrix = 'SELECT * FROM perangkingan WHERE idk IN (SELECT idk FROM kriteria WHERE metode = "SAW")';
$data_decision_matrix = $conn->query($sql_decision_matrix);
$min_values = array();
$max_values = array();
$sql_kriteria_values = 'SELECT idk, MIN(nilai_min) AS nilai_min, MAX(nilai_max) AS nilai_max FROM kriteria WHERE metode = "SAW" GROUP BY idk';
$data_kriteria_values = $conn->query($sql_kriteria_values);

while ($row_kriteria_values = $data_kriteria_values->fetch_object()) {
    $min_values[$row_kriteria_values->idk] = $row_kriteria_values->nilai_min;
    $max_values[$row_kriteria_values->idk] = $row_kriteria_values->nilai_max;
}

while ($row_decision_matrix = $data_decision_matrix->fetch_object()) {
    $j = $row_decision_matrix->idk;
    $v = $row_decision_matrix->value;
    $decision_matrix[$row_decision_matrix->iddaftar][$j] = $v;
}
?>

<?php
if (isset($_POST['proses_perhitungan'])) {
    $normalized_matrix = array();
    foreach ($decision_matrix as $i => $x_i) {
        $normalized_matrix[$i] = array();
        foreach ($x_i as $j => $x_ij) {
            if ($criteria_data[$j][1] == 'cost') {
                $normalized_matrix[$i][$j] = $min_values[$j] / $x_ij;
            } else {
                $normalized_matrix[$i][$j] = $x_ij / $max_values[$j];
            }
        }
    }

    $preference_values = array();
    foreach ($normalized_matrix as $i => $r_i) {
        $preference_values[$i] = 0;
        foreach ($r_i as $j => $r_ij) {
            $preference_values[$i] += $bobot[$j] * $r_ij;
        }
    }

    arsort($preference_values);

    // Simpan nilai preferensi ke dalam tabel pendaftaran
    foreach ($preference_values as $iddaftar => $preference) {
        $sqlUpdatePref = "UPDATE pendaftaran SET preferensi = '$preference' WHERE iddaftar = '$iddaftar'";
        if ($conn->query($sqlUpdatePref) !== TRUE) {
            echo "Error updating record: " . $conn->error;
        }
    }
}
?>

<div class="container mb-4">
    <div class="card">
        <p class="card-header">Proses SAW</p>
        <div class="card-body">
            <p>Silakan klik tombol di bawah ini untuk memulai proses perangkingan menggunakan metode SAW.</p>
            <form class="" action="" method="POST">
                <input type="submit" name="proses_perhitungan" value="Perangkingan" class="btn btn-dark">
            </form>
        </div>
    </div>
</div>

<!-- Matriks Keputusan -->
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-dark text-white border-dark">
            <div class="toggle-button" onclick="toggleTable('matrikstableContainer')">
                <span id="matrikstoggleIcon">&#9660;</span> <span id="matrikstoggleText">Matriks Keputusan (X):</span>
            </div>
        </div>
        <div id="matrikstableContainer" class="hidden-content">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Nama</th>
                        <?php foreach ($criteria_data as $id => $detail) : ?>
                            <th><?= $detail[0] ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($decision_matrix as $iddaftar => $criteria_values) : ?>
                        <tr>
                            <td><?php echo $u++ ?></td>
                            <td><?= $alternatives[$iddaftar] ?></td>
                            <?php foreach ($criteria_values as $idk => $value) : ?>
                                <td><?= $value ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if (isset($_POST['proses_perhitungan'])) : ?>
    <!-- Matriks Normalisasi -->
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-dark text-white border-dark">
                <div class="toggle-button" onclick="toggleTable('normalizedTable')">
                    <span id="normalizedToggleIcon">&#9660;</span> <span id="normalizedToggleText">Matriks Normalisasi (R):</span>
                </div>
            </div>
            <div id="normalizedTable" class="hidden-content">
                <table class="table table-bordered mt-4">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Nama</th>
                            <?php foreach ($criteria_data as $id => $detail) : ?>
                                <th><?= $detail[0] ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $u = 1; // Reset nomor urut
                        foreach ($normalized_matrix as $iddaftar => $criteria_values) : ?>
                            <tr>
                                <td><?php echo $u++ ?></td>
                                <td><?= $alternatives[$iddaftar] ?></td>
                                <?php foreach ($criteria_values as $idk => $value) : ?>
                                    <td><?= number_format($value, 2) ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Nilai Preferensi -->
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-dark text-white border-dark">
                <div class="toggle-button" onclick="toggleTable('preferenceTable')">
                    <span id="preferenceToggleIcon">&#9660;</span> <span id="preferenceToggleText">Nilai Preferensi (P):</span>
                </div>
            </div>
            <div id="preferenceTable" class="hidden-content">
                <table class="table table-bordered mt-4">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Nama</th>
                            <th>Preferensi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $rank = 1;
                        foreach ($preference_values as $i => $preference) : ?>
                            <tr>
                                <td><?= $rank ?></td>
                                <td><?= $alternatives[$i] ?></td>
                                <td><?= $preference ?></td>
                            </tr>
                        <?php
                            $rank++;
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="mt-5" style="display: flex;">
        <div style="flex: 1;">
            <div id="map"></div>
        </div>
        <div style="flex: 1; padding-left: 20px;">
            <img width="40px" src="gambar/number1.png" alt=""><b>: Best Candidat</b><br>
            <img width="40px" src="gambar/number2.png" alt=""><b>: Candidat</b><br>
            <img width="40px" src="gambar/more.png" alt=""><b>: Umum</b>
        </div>
    </div>

    <?php
    include 'model_perangkingan.php';
    ?>
    <style>
        #map {
            height: 550px;
            width: 700px;
        }
    </style>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.48.0/mapbox-gl.css' rel='stylesheet' />
    <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v2.3.0/mapbox-gl-geocoder.css' type='text/css' />
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.48.0/mapbox-gl.js'></script>
    <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v2.3.0/mapbox-gl-geocoder.min.js'></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        var markers = <?= get_lokasi() ?>;
        var lokasi_parepare = [119.6290, -4.0099];
        var maxPreferensi1; // Deklarasi variabel pertama di sini
        var maxPreferensi2; // Deklarasi variabel kedua di sini

        mapboxgl.accessToken = 'pk.eyJ1IjoiZmFkbHVsbGFoeCIsImEiOiJjbHI0bmZrejcxYmx0MmpudjVkMzRjbm43In0.O_h7GYI9fXaoHr9XnIN5sg';
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v9',
            center: lokasi_parepare,
            zoom: 16
        });

        function addMarker(ltlng, imgSrc) {
            var img = document.createElement('img');
            img.src = imgSrc;
            img.style.width = '35px';
            img.style.height = '35px';

            new mapboxgl.Marker({
                    draggable: true,
                    element: img
                })
                .setLngLat(ltlng)
                .addTo(map);
        }

        map.on('load', function() {
            // Mendapatkan nilai preferensi tertinggi pertama
            maxPreferensi1 = Math.max.apply(Math, markers.map(function(marker) {
                return marker[4];
            }));

            // Mengatur nilai tertinggi pertama ke nilai terendah
            markers = markers.map(function(marker) {
                if (parseFloat(marker[4]) === parseFloat(maxPreferensi1)) {
                    maxPreferensi1 = Number.MIN_VALUE; // Set nilai ke nilai terendah
                    return [marker[0], marker[1], marker[2], marker[3], maxPreferensi1];
                }
                return marker;
            });

            // Mendapatkan nilai preferensi tertinggi kedua
            maxPreferensi2 = Math.max.apply(Math, markers.map(function(marker) {
                return marker[4];
            }));

            // Menambahkan marker dengan gambar sesuai dengan nilai preferensi tertinggi pertama dan kedua
            add_markers(markers, maxPreferensi1, maxPreferensi2);
        });

        function add_markers(coordinates, maxPreferensi1, maxPreferensi2) {
            var geojson = (coordinates == markers ? coordinates : '');
            geojson.forEach(function(marker) {
                var imgSrc = 'gambar/more.png';

                // Memeriksa apakah nilai preferensi sama dengan nilai preferensi tertinggi pertama atau kedua
                if (parseFloat(marker[4]) === parseFloat(maxPreferensi1)) {
                    imgSrc = 'gambar/number1.png'; // Ganti dengan nama gambar yang sesuai untuk nilai tertinggi pertama
                } else if (parseFloat(marker[4]) === parseFloat(maxPreferensi2)) {
                    imgSrc = 'gambar/number2.png'; // Ganti dengan nama gambar yang sesuai untuk nilai tertinggi kedua
                }

                addMarker([marker[1], marker[2]], imgSrc);
            });
        }
    </script>
<?php endif; ?>

<script>
    function toggleTable(tableId) {
        var tableContainer = document.getElementById(tableId);
        var toggleIcon = document.getElementById(tableId + 'ToggleIcon');
        var toggleText = document.getElementById(tableId + 'ToggleText');

        if (tableContainer.classList.contains('hidden-content')) {
            tableContainer.classList.remove('hidden-content');
            toggleIcon.innerHTML = '&#9650;'; // Panah ke atas
            toggleText.innerHTML = 'Sembunyikan Tabel';
        } else {
            tableContainer.classList.add('hidden-content');
            toggleIcon.innerHTML = '&#9660;'; // Panah ke bawah
            toggleText.innerHTML = 'Tampilkan Tabel';
        }
    }
</script>

<style>
    .table-container {
        position: relative;
    }

    .toggle-button {
        cursor: pointer;
        font-size: 1.2em;
        display: flex;
        align-items: center;
    }

    .toggle-button span {
        margin-left: 10px;
    }

    .hidden-content {
        display: none;
    }
</style>