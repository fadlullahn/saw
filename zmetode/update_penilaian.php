<?php
if (isset($_POST['update'])) {
    $iddaftar = $_POST['iddaftar'];
    $idk = $_POST['idk'];
    $value = $_POST['value'];

    // Pastikan memakai prepared statement untuk menghindari SQL injection
    $sql_update = "UPDATE perangkingan SET value = ? WHERE iddaftar = ? AND idk = ?";
    $stmt = $conn->prepare($sql_update);

    if ($stmt) {
        // Bind parameter
        $stmt->bind_param("iii", $value, $iddaftar, $idk);

        // Eksekusi statement
        if ($stmt->execute()) {
            echo "<div class='alert alert-success' role='alert'>Perubahan berhasil disimpan.</div>";
            echo '<script>window.history.go(-2);</script>';
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error: " . $stmt->error . "</div>";
        }

        // Tutup statement
        $stmt->close();
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error: " . $conn->error . "</div>";
    }
}

if (isset($_GET['idd']) && isset($_GET['idk'])) {
    $iddaftar = $_GET['idd'];
    $idk = $_GET['idk'];
    $sql_perangkingan = "SELECT * FROM perangkingan WHERE iddaftar = ? AND idk = ?";
    $stmt = $conn->prepare($sql_perangkingan);
    $stmt->bind_param("ii", $iddaftar, $idk);
    $stmt->execute();
    $result_perangkingan = $stmt->get_result();

    if ($result_perangkingan->num_rows > 0) {
        $perangkingan = $result_perangkingan->fetch_object();
?>

        <!DOCTYPE html>
        <html>

        <head>
            <title>Update Perangkingan</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        </head>

        <body>
            <div class="container mt-5">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <strong>Update Perangkingan</strong>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <input type="hidden" name="iddaftar" value="<?= htmlspecialchars($perangkingan->iddaftar) ?>">
                            <input type="hidden" name="idk" value="<?= htmlspecialchars($perangkingan->idk) ?>">

                            <?php
                            if ($perangkingan->idk == 31) {
                            ?>
                                <div class="form-group">
                                    <label for="value">Nilai:</label>
                                    <select class="form-control" name="value">
                                        <option value="5" <?= ($perangkingan->value == 5) ? 'selected' : '' ?>>≥ 50.000.000</option>
                                        <option value="4" <?= ($perangkingan->value == 4) ? 'selected' : '' ?>>30.000.000 - 49.999.999</option>
                                        <option value="3" <?= ($perangkingan->value == 3) ? 'selected' : '' ?>>10.000.000 - 29.999.999</option>
                                        <option value="2" <?= ($perangkingan->value == 2) ? 'selected' : '' ?>>5.000.000 - 9.999.999</option>
                                        <option value="1" <?= ($perangkingan->value == 1) ? 'selected' : '' ?>>≤ 4.999.999</option>
                                    </select>
                                </div>
                            <?php
                            } elseif ($perangkingan->idk == 33) {
                            ?>
                                <div class="form-group">
                                    <label for="value">Nilai:</label>
                                    <select class="form-control" name="value">
                                        <option value="1" <?= ($perangkingan->value == 1) ? 'selected' : '' ?>>Y ≥ 5 KM</option>
                                        <option value="2" <?= ($perangkingan->value == 2) ? 'selected' : '' ?>>3 KM ≤ Y ≤ 5 KM</option>
                                        <option value="3" <?= ($perangkingan->value == 3) ? 'selected' : '' ?>>1 KM ≤ Y ≤ 3 KM</option>
                                        <option value="4" <?= ($perangkingan->value == 4) ? 'selected' : '' ?>>500 ≤ Y 1 KM</option>
                                        <option value="5" <?= ($perangkingan->value == 5) ? 'selected' : '' ?>>Y ≤ 500 M</option>
                                    </select>
                                </div>
                            <?php
                            } elseif ($perangkingan->idk == 34) {
                            ?>
                                <div class="form-group">
                                    <label for="value">Nilai:</label>
                                    <select class="form-control" name="value">
                                        <option value="1" <?= ($perangkingan->value == 1) ? 'selected' : '' ?>>Tidak Aman</option>
                                        <option value="2" <?= ($perangkingan->value == 2) ? 'selected' : '' ?>>Sedang</option>
                                        <option value="3" <?= ($perangkingan->value == 3) ? 'selected' : '' ?>>Sangat Aman</option>
                                    </select>
                                </div>
                            <?php
                            } elseif ($perangkingan->idk == 35) {
                            ?>
                                <div class="form-group">
                                    <label for="value">Nilai:</label>
                                    <select class="form-control" name="value">
                                        <option value="1" <?= ($perangkingan->value == 1) ? 'selected' : '' ?>>Tidak Lengkap</option>
                                        <option value="2" <?= ($perangkingan->value == 2) ? 'selected' : '' ?>>Cukup</option>
                                        <option value="3" <?= ($perangkingan->value == 3) ? 'selected' : '' ?>>Lengkap</option>
                                    </select>
                                </div>
                            <?php
                            } elseif ($perangkingan->idk == 36) {
                            ?>
                                <div class="form-group">
                                    <label for="value">Nilai:</label>
                                    <select class="form-control" name="value">
                                        <option value="1" <?= ($perangkingan->value == 1) ? 'selected' : '' ?>>Tidak Ramai</option>
                                        <option value="2" <?= ($perangkingan->value == 2) ? 'selected' : '' ?>>Cukup Ramai</option>
                                        <option value="3" <?= ($perangkingan->value == 3) ? 'selected' : '' ?>>Sangat Ramai</option>
                                    </select>
                                </div>
                            <?php
                            } else {
                            ?>
                                <div class="form-group">
                                    <label for="value">Nilai:</label>
                                    <input type="text" class="form-control" name="value" value="<?= htmlspecialchars($perangkingan->value) ?>">
                                </div>
                            <?php
                            }
                            ?>
                            <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        </body>

        </html>

<?php
    } else {
        echo "<div class='alert alert-danger' role='alert'>Data perangkingan tidak ditemukan.</div>";
    }
} else {
    echo "<div class='alert alert-danger' role='alert'>ID Kriteria (idk) atau ID Daftar (iddaftar) tidak ditemukan.</div>";
}
?>