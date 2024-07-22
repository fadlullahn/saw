<div class="container mt-5">
    <div class="card border-dark">
        <div class="card-header bg-success text-white">
            <strong>Data Kriteria</strong>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end mb-2">
                <a class="btn btn-success" href="?page=kriteria&action=tambah">Tambah</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="myTable">
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
                                    <a class="btn btn-warning btn-sm" href="?page=kriteria&action=update&idk=<?php echo $row['idk']; ?>">
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

<script>
    $(document).ready(function() {
        $('#myTable').dataTable();
    });
</script>