<div class="container mt-5">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-dark text-white">
            <strong>Data Kriteria</strong>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end mb-3">
                <a class="btn btn-dark" href="?page=kriteria&action=tambah"><i class="fas fa-plus"></i> Tambah</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="myTable">
                    <thead class="thead-dark">
                        <tr>
                            <th width="50px">No</th>
                            <th width="100px">Metode</th>
                            <th width="160px">Nama Kriteria</th>
                            <th width="100px">Jenis Kriteria</th>
                            <th width="80px">Bobot</th>
                            <th width="100px">Nilai Max</th>
                            <th width="100px">Nilai Min</th>
                            <th width="80px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $sql = "SELECT * FROM kriteria ORDER BY idk ASC";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo htmlspecialchars($row['metode']); ?></td>
                                <td><?php echo htmlspecialchars($row['nama_k']); ?></td>
                                <td><?php echo htmlspecialchars($row['jenis_k']); ?></td>
                                <td><?php echo htmlspecialchars($row['bobot']); ?></td>
                                <td><?php echo htmlspecialchars($row['nilai_max']); ?></td>
                                <td><?php echo htmlspecialchars($row['nilai_min']); ?></td>
                                <td>
                                    <a class="btn btn-dark btn-sm" href="?page=kriteria&action=update&idk=<?php echo $row['idk']; ?>">
                                        <span class="fas fa-edit"></span>
                                    </a>
                                    <a onclick="return confirm('Yakin Ingin Menghapus Data ini?')" class="btn btn-danger btn-sm" href="?page=kriteria&action=hapus&idk=<?php echo $row['idk']; ?>">
                                        <span class="fas fa-trash-alt"></span>
                                    </a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>

<style>
    .card {
        border-radius: 10px;
    }

    .card-header {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .table thead th {
        background-color: #343a40;
        color: #ffffff;
        border: none;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .table td,
    .table th {
        border: none;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .btn {
        border-radius: 5px;
    }

    .btn-success {
        background-color: #28a745;
        border: none;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .btn-warning {
        background-color: #ffc107;
        border: none;
    }

    .btn-warning:hover {
        background-color: #e0a800;
    }

    .btn-danger {
        background-color: #dc3545;
        border: none;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }
</style>