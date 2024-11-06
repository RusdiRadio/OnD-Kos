<?php
require_once "../koneksi.php";

// Query untuk mengambil semua data dari tabel daftar_user
$sql = "SELECT * FROM daftar_user";
$query = mysqli_query($koneksi, $sql);

$dataUser = [];

if (mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {
        $dataUser[] = $row;
    }
}

// Mengembalikan data dalam format JSON
echo json_encode($dataUser);
?>