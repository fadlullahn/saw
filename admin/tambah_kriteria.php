<?php
if (isset($_POST['simpan'])) {
    // Ambil data dari input
    $nama_k = $_POST['nama_k'];
    $jenis_k = $_POST['jenis_k'];
    $bobot = $_POST['bobot'];
    $nilai_max = $_POST['nilai_max'];
    $nilai_min = $_POST['nilai_min'];
    $metode = $_POST['metode']; // Menambah input untuk metode

    // Validasi Data K Berdasarkan Nama K dan Metode
    $sql = "SELECT * FROM kriteria WHERE nama_k='$nama_k' AND metode='$metode'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Data Tidak Tersimpan Karena Nama K Sudah Digunakan pada Metode yang Sama</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
<?php
    } else {
        // Proses simpan setelah divalidasi
        $sql_insert_kriteria = "INSERT INTO kriteria (nama_k, jenis_k, bobot, nilai_max, nilai_min, metode) VALUES ('$nama_k', '$jenis_k', '$bobot', '$nilai_max', '$nilai_min', '$metode')";

        if ($conn->query($sql_insert_kriteria) === TRUE) {
            // Mendapatkan idk yang baru ditambahkan
            $new_idk = $conn->insert_id;
            header("Location:?page=kriteria");
        }
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-dark">
                <div class="card-header bg-success text-white">
                    <strong>Input Data Kriteria</strong>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="metode">Metode</label>
                            <select class="form-control" name="metode" required>
                                <option value="SAW">SAW</option>
                                <option value="ARAS">ARAS</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_k">Nama Kriteria</label>
                            <input type="text" class="form-control" name="nama_k" maxlength="255" required>
                        </div>
                        <div class="form-group">
                            <label for="jenis_k">Jenis Kriteria</label>
                            <select class="form-control" name="jenis_k" required>
                                <option value="benefit">Benefit</option>
                                <option value="cost">Cost</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="bobot">Bobot</label>
                            <input type="text" class="form-control" name="bobot" required>
                        </div>
                        <div class="form-group">
                            <label for="nilai_max">Nilai Max</label>
                            <input type="text" class="form-control" name="nilai_max" required>
                        </div>
                        <div class="form-group">
                            <label for="nilai_min">Nilai Min</label>
                            <input type="text" class="form-control" name="nilai_min" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <input class="btn btn-primary" type="submit" name="simpan" value="Simpan">
                            <a class="btn btn-danger" href="?page=kriteria">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#myTable').dataTable();
    });
</script>