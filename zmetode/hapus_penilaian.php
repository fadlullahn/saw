<?php
$iddaftar = $_GET['iddaftar'];

// Hapus data di tabel pendaftaran
$sql_pendaftaran = "DELETE FROM pendaftaran WHERE iddaftar='$iddaftar'";
if ($conn->query($sql_pendaftaran) === TRUE) {
    // Hapus data di tabel perangkingan yang memiliki iddaftar yang sama
    $sql_perangkingan = "DELETE FROM perangkingan WHERE iddaftar='$iddaftar'";
    $conn->query($sql_perangkingan);

    header("Location:?page=penilaian_saw");
    exit(); // Pastikan untuk keluar setelah header redirect
} else {
    echo '<div class="alert alert-danger" role="alert">Error: ' . $conn->error . '</div>';
}

$conn->close();
