<?php
require_once "../koneksi.php";

$sql = "SELECT * FROM kamar";
$query = mysqli_query($koneksi, $sql);

$dataKamar = [];

if (mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {
        $dataKamar[] = $row;
    }
}

echo json_encode($dataKamar);
?>
