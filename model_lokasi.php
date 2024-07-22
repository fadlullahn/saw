<?php
require("config.php");

if (isset($_GET['tambah_lokasi'])) {
    tambah_lokasi();
}

function tambah_lokasi()
{
    global $conn;

    $lat = $_GET['latitude'];
    $lng = $_GET['longitude'];
    $nama = $_GET['nama']; // Baris tambahan untuk mendapatkan nilai 'nama'

    // Inserts new row with place data.
    $query = sprintf(
        "INSERT INTO lokasi " .
            " (idl, latitude, longitude, nama) " . // Menambahkan 'nama' ke daftar kolom
            " VALUES (NULL, '%s', '%s', '%s');", // Menambahkan '%s' untuk 'nama'
        mysqli_real_escape_string($conn, $lat),
        mysqli_real_escape_string($conn, $lng),
        mysqli_real_escape_string($conn, $nama) // Menambahkan 'nama' ke daftar nilai
    );

    $result = mysqli_query($conn, $query);
    echo json_encode("Data Lokasi Berhasil Di Simpan");

    if (!$result) {
        die('Invalid query: ' . mysqli_error($conn));
    }
}

function get_lokasi()
{
    global $conn;

    $sqldata = mysqli_query($conn, "SELECT longitude, latitude, nama FROM lokasi"); // Menambahkan 'nama' ke SELECT

    $rows = array();

    while ($r = mysqli_fetch_assoc($sqldata)) {
        $rows[] = $r;
    }

    $indexed = array_map('array_values', $rows);

    echo json_encode($indexed);

    if (!$rows) {
        return null;
    }
}
