<?php
if (isset($_POST['update'])) {

    // Ambil Data Dari Input Yang Mau Di Update
    $idk = $_POST['idk'];
    $nama_k = $_POST['nama_k'];
    $jenis_k = $_POST['jenis_k'];
    $bobot = $_POST['bobot'];
    $nilai_max = $_POST['nilai_max'];
    $nilai_min = $_POST['nilai_min'];
    $metode = $_POST['metode'];

    // Proses Update Data Kriteria
    $sql = "UPDATE kriteria SET nama_k='$nama_k', jenis_k='$jenis_k', bobot='$bobot', nilai_max='$nilai_max', nilai_min='$nilai_min', metode='$metode' WHERE idk='$idk'";
    if ($conn->query($sql) === TRUE) {
        header("Location:?page=kriteria");
    }
}

// Memanggil Data Yang Mau Di Edit
$idk = $_GET['idk'];

$sql = "SELECT * FROM kriteria WHERE idk='$idk'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-dark">
                <div class="card-header bg-dark text-white">
                    <strong>Update Data Kriteria</strong>
                </div>
                <div class="card-body">
                    <form action="" method="POST">

                        <input type="hidden" name="idk" value="<?php echo $row["idk"] ?>">

                        <div class="form-group">
                            <label for="metode">Metode</label>
                            <input type="text" class="form-control" value="<?php echo $row["metode"] ?>" name="metode" readonly>
                        </div>

                        <div class="form-group">
                            <label for="nama_k">Nama Kriteria</label>
                            <input type="text" class="form-control" value="<?php echo $row["nama_k"] ?>" name="nama_k" maxlength="255" readonly>
                        </div>

                        <div class="form-group">
                            <label for="jenis_k">Jenis Kriteria</label>
                            <select class="form-control" name="jenis_k" required>
                                <option value="benefit" <?php echo ($row["jenis_k"] == "benefit") ? "selected" : ""; ?>>Benefit</option>
                                <option value="cost" <?php echo ($row["jenis_k"] == "cost") ? "selected" : ""; ?>>Cost</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="bobot">Bobot</label>
                            <input type="text" class="form-control" value="<?php echo $row["bobot"] ?>" name="bobot" required>
                        </div>

                        <div class="form-group">
                            <label for="nilai_max">Nilai Max</label>
                            <input type="text" class="form-control" value="<?php echo $row["nilai_max"] ?>" name="nilai_max" required>
                        </div>

                        <div class="form-group">
                            <label for="nilai_min">Nilai Min</label>
                            <input type="text" class="form-control" value="<?php echo $row["nilai_min"] ?>" name="nilai_min" required>
                        </div>

                        <div class="d-flex justify-content-between">
                            <input class="btn btn-dark" type="submit" name="update" value="Update">
                            <a class="btn btn-danger" href="?page=kriteria">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>