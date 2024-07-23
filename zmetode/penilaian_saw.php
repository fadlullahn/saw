<?php
// Mengambil data alternatif
$alternatives = array();
$sql_alternatives = 'SELECT * FROM pendaftaran';
$data_alternatives = $conn->query($sql_alternatives);
while ($row_alternatives = $data_alternatives->fetch_object()) {
    $alternatives[$row_alternatives->iddaftar] = $row_alternatives->name;
}

// Mengambil data kriteria dengan metode SAW
$criteria_data = array();
$bobot = array();
$sql_criteria = 'SELECT * FROM kriteria WHERE metode = "SAW"';
$data_criteria = $conn->query($sql_criteria);
while ($row_criteria = $data_criteria->fetch_object()) {
    $criteria_data[$row_criteria->idk] = array($row_criteria->nama_k, $row_criteria->jenis_k);
    $bobot[$row_criteria->idk] = $row_criteria->bobot;
}

// Mengambil data matriks keputusan
$i = 1;
$decision_matrix = array();
$sql_decision_matrix = 'SELECT * FROM perangkingan WHERE idk IN (SELECT idk FROM kriteria WHERE metode = "SAW")';
$data_decision_matrix = $conn->query($sql_decision_matrix);
$min_values = array();
$max_values = array();
$sql_kriteria_values = 'SELECT idk, MIN(nilai_min) AS nilai_min, MAX(nilai_max) AS nilai_max FROM kriteria WHERE metode = "SAW" GROUP BY idk';
$data_kriteria_values = $conn->query($sql_kriteria_values);
while ($row_kriteria_values = $data_kriteria_values->fetch_object()) {
    $min_values[$row_kriteria_values->idk] = $row_kriteria_values->nilai_min;
    $max_values[$row_kriteria_values->idk] = $row_kriteria_values->nilai_max;
}
while ($row_decision_matrix = $data_decision_matrix->fetch_object()) {
    $j = $row_decision_matrix->idk;
    $v = $row_decision_matrix->value;
    $decision_matrix[$row_decision_matrix->iddaftar][$j] = $v;
}
?>

<div class="card">
    <div class="card-header bg-dark text-white border-dark">
        <strong>Data Pendaftaran SAW</strong>
    </div>
    <div class="card-body">
        <a class="btn btn-dark mb-2" href="?page=pendaftaran&action=tambah">Tambah</a>
        <table class="table table-bordered table-striped" id="myTable">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Nama</th>
                    <?php foreach ($criteria_data as $id => $detail) : ?>
                        <th><?= $detail[0] ?></th>
                    <?php endforeach; ?>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($decision_matrix as $iddaftar => $criteria_values) : ?>
                    <tr>
                        <td><?php echo $i++ ?></td>
                        <td><?= isset($alternatives[$iddaftar]) ? $alternatives[$iddaftar] : ''; ?></td>
                        <?php foreach ($criteria_values as $idk => $value) : ?>
                            <td>
                                <span class="text-black"><?= $value ?></span>

                                <a href="?page=penilaian_saw&action=update&idd=<?= $iddaftar ?>&idk=<?= $idk ?>" class="ml-2">
                                    <span class="fas fa-edit text-dark"></span>
                                </a>
                            </td>
                        <?php endforeach; ?>
                        <td>
                            <a onclick="return confirm('Yakin Ingin Menghapus Data ini ?')" class="btn btn-danger" href="?page=penilaian_saw&action=hapus&iddaftar=<?php echo $iddaftar; ?>">
                                <span class="fas fa-trash-alt"></span>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>