<?php
require("config.php");



function get_lokasi()
{
    global $conn;

    $sqldata = mysqli_query($conn, "SELECT iddaftar, longitude, latitude, name, preferensi FROM pendaftaran");

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
