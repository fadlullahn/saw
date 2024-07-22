<?php

$idk = $_GET['idk'];

$sql = "DELETE FROM kriteria WHERE idk='$idk'";
if ($conn->query($sql) === TRUE) {
    header("Location:?page=kriteria");
}
$conn->close();
