<?php

$idl = $_GET['idl'];

$sql = "DELETE FROM lokasi WHERE idl='$idl'";
if ($conn->query($sql) === TRUE) {
    header("Location:?page=lokasi");
}
$conn->close();
