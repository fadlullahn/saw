<?php
// Fungsi untuk mendapatkan iddaftar yang belum digunakan
function getAvailableIdDaftar($conn)
{
    $sql = "SELECT iddaftar FROM pendaftaran ORDER BY iddaftar";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $currentIdDaftar = 1;

        while ($row = $result->fetch_assoc()) {
            if ($row['iddaftar'] != $currentIdDaftar) {
                return $currentIdDaftar;
            }

            $currentIdDaftar++;
        }
    }

    return $currentIdDaftar;
}

// Ambil data idl, nama, latitude, dan longitude dari tabel lokasi
$getLokasi = "SELECT idl, nama, latitude, longitude FROM lokasi";
$Lokasi = $conn->query($getLokasi);

// Proses tambah pendaftaran
if (isset($_POST['simpan'])) {
    $ambilidl = $_POST['idl'];

    // Ambil data nama, latitude, dan longitude dari tabel lokasi berdasarkan idl yang dipilih
    $sqlDataLokasi = "SELECT nama, latitude, longitude FROM lokasi WHERE idl = '$ambilidl'";
    $DataLokasi = $conn->query($sqlDataLokasi);

    if ($DataLokasi->num_rows > 0) {
        $rowDataLokasi = $DataLokasi->fetch_assoc();
        $name = $rowDataLokasi['nama'];
        $latitude = $rowDataLokasi['latitude'];
        $longitude = $rowDataLokasi['longitude'];

        // Mendapatkan iddaftar yang belum digunakan
        $lastInsertedId = getAvailableIdDaftar($conn);

        // Tambahkan data pendaftaran ke tabel pendaftaran
        $sqlPendaftaran = "INSERT INTO pendaftaran (iddaftar, name, latitude, longitude) VALUES ('$lastInsertedId', '$name', '$latitude', '$longitude')";

        if ($conn->query($sqlPendaftaran) === TRUE) {
            echo "Data pendaftaran berhasil disimpan.";

            // Ambil semua data kriteria dari tabel kriteria
            $sqlKriteria = "SELECT idk FROM kriteria";
            $resultKriteria = $conn->query($sqlKriteria);

            if ($resultKriteria->num_rows > 0) {
                while ($rowKriteria = $resultKriteria->fetch_assoc()) {
                    $idk = $rowKriteria['idk'];

                    // Tambahkan data ke tabel perangkingan dengan nilai 0
                    $sqlPerangkingan = "INSERT INTO perangkingan (iddaftar, idk, value) VALUES ('$lastInsertedId', '$idk', 0)";

                    if ($conn->query($sqlPerangkingan) !== TRUE) {
                        echo "Error: " . $sqlPerangkingan . "<br>" . $conn->error;
                    }
                }
                echo "Data perangkingan berhasil disimpan.";
                header("Location:?page=penilaian_saw");
            } else {
                echo "Tidak ada data kriteria.";
            }
        } else {
            echo "Error: " . $sqlPendaftaran . "<br>" . $conn->error;
        }
    } else {
        echo "Data lokasi tidak ditemukan untuk idl tersebut.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Form Pendaftaran</title>
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <strong>Form Pendaftaran</strong>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="idl">Lokasi:</label>
                        <select class="form-control" name="idl" required>
                            <?php
                            while ($row_lokasi = $Lokasi->fetch_assoc()) {
                                echo "<option value='" . $row_lokasi['idl'] . "'>" . $row_lokasi['nama'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" name="simpan" class="btn btn-dark">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>