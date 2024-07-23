<div class="card">
    <div class="card-header bg-dark text-white border-dark">
        <strong>Data Lokasi</strong>
    </div>
    <div class="card-body">
        <a class="btn btn-dark mb-2" href="?page=lokasi&action=tambah">Tambah</a>
        <div class="table-responsive">
            <table class="table table-bordered" id="lokasiTable">
                <thead class="thead-dark">
                    <tr>
                        <th width="50px">No</th>
                        <th width="160px">Nama</th>
                        <th width="160px">Latitude</th>
                        <th width="160px">Longitude</th>
                        <th width="80px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $sql = "SELECT * FROM lokasi ORDER BY idl ASC";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $row['nama']; ?></td>
                            <td><?php echo $row['latitude']; ?></td>
                            <td><?php echo $row['longitude']; ?></td>
                            <td>
                                <a onclick="return confirm('Yakin Ingin Menghapus Data ini ?')" class="btn btn-danger btn-sm" href="?page=lokasi&action=hapus&idl=<?php echo $row['idl']; ?>">
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