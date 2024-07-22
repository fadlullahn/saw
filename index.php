<?php
date_default_timezone_set("Asia/Jakarta");
// Aktifkan Session
session_start();
require "config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SAW</title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/datatables.min.css">
    <link rel="stylesheet" href="assets/css/all.css">
    <link rel="stylesheet" href="assets/css/bootstrap-chosen.css">
</head>

<body>
    <!-- Cek Status Login Atau Belum -->
    <?php
    if ($_SESSION['status'] != "y") {
        header("Location:login.php");
    }
    ?>
    <!-- START MENU -->
    <nav class="navbar navbar-dark bg-success navbar-expand-sm fixed-top">
        <a class="navbar-brand" href="index.php">SPK LOKASI USAHA</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active"><a class="nav-link" href="index.php"><i class="fas fa-house-damage"></i> Home</a></li>
                <li class="nav-item active"><a class="nav-link" href="?page=kriteria"><i class="fas fa-book-reader"></i> Kriteria</a></li>
                <li class="nav-item active"><a class="nav-link" href="?page=lokasi"><i class="fas fa-globe"></i> Lokasi</a></li>
                <li class="nav-item active"><a class="nav-link" href="?page=penilaian_saw"><i class="fas fa-file-alt"></i> Penilaian</a></li>
                <li class="nav-item active"><a class="nav-link" href="?page=perangkingan_saw"><i class="fas fa-award"></i> Perangkingan</a></li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active"><a class="nav-link" href="?page=logout"><i class="fas fa-sign-in-alt"></i> Logout</a></li>
            </ul>
        </div>
    </nav>
    <!-- END MENU -->

    <div class="container" style="margin-top:100px;margin-bottom:100px">
        <?php
        // Pengaturan MENU
        $page = isset($_GET['page']) ? $_GET['page'] : "";
        $action = isset($_GET['action']) ? $_GET['action'] : "";

        // ADMIN
        if ($page == "") {
            include "welcome.php";
        } elseif ($page == "lokasi") {
            if ($action == "") {
                include "tampil_lokasi.php";
            } elseif ($action == "tambah") {
                include "mapbox.php";
            } else {
                include "hapus_lokasi.php";
            }
        } elseif ($page == "kriteria") {
            if ($action == "") {
                include "admin/tampil_kriteria.php";
            } elseif ($action == "tambah") {
                include "admin/tambah_kriteria.php";
            } elseif ($action == "update") {
                include "admin/update_kriteria.php";
            } else {
                include "admin/hapus_kriteria.php";
            }
        }
        // END ADMIN
        // START METODE
        elseif ($page == "penilaian_saw") {
            if ($action == "") {
                include "zmetode/penilaian_saw.php";
            } elseif ($action == "update") {
                include "zmetode/update_penilaian.php";
            } else {
                include "zmetode/hapus_penilaian.php";
            }
        } elseif ($page == "perangkingan_saw") {
            if ($action == "") {
                include "zmetode/perangkingan_saw.php";
            }
        } elseif ($page == "pendaftaran") {
            if ($action == "tambah") {
                include "zmetode/tambah_pendaftaran.php";
            }
        }
        // END METODE
        else {
            if ($action == "") {
                include "logout.php";
            }
        }
        ?>
    </div>

    <script src="assets/js/jquery-3.7.0.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/all.js"></script>
    <script src="assets/js/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').dataTable();
        });
    </script>

    <script src="assets/js/chosen.jquery.min.js"></script>
    <script>
        $(function() {
            $('.chosen').chosen();
        });
    </script>

</body>

</html>