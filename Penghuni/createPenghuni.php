<?php
require_once "../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $pekerjaan = $_POST['pekerjaan'];
    $id_kamar = $_POST['id_kamar'];
    $id_laporan_p = $_POST['id_laporan_p'];
    $id_transaksi = $_POST['id_transaksi'];
    $id_riwayat = $_POST['id_riwayat'];
    $id_user = $_POST['id_user'];

    // Query untuk insert data ke database
    $sql = "INSERT INTO penghuni (nama, pekerjaan, id_kamar, id_laporan_p, id_transaksi, id_riwayat, id_user) 
            VALUES ('$nama', '$pekerjaan', '$id_kamar', '$id_laporan_p', '$id_transaksi', '$id_riwayat', '$id_user')";

    // Eksekusi query
    if (mysqli_query($koneksi, $sql)) {
        echo "Data berhasil ditambahkan!";
        header("Location: index4.php"); // Redirect ke halaman index setelah berhasil menambah data
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Penghuni</title>
</head>
<body>
    <h1>Tambah Data Penghuni</h1>
    <form action="createPenghuni.php" method="POST">
        <label for="nama">Nama:</label><br>
        <input type="text" id="nama" name="nama" required><br><br>

        <label for="pekerjaan">Pekerjaan:</label><br>
        <input type="text" id="pekerjaan" name="pekerjaan" required><br><br>

        <label for="id_kamar">ID Kamar:</label><br>
        <input type="number" id="id_kamar" name="id_kamar" required><br><br>

        <label for="id_laporan_p">ID Laporan:</label><br>
        <input type="number" id="id_laporan_p" name="id_laporan_p" required><br><br>

        <label for="id_transaksi">ID Transaksi:</label><br>
        <input type="number" id="id_transaksi" name="id_transaksi" required><br><br>

        <label for="id_riwayat">ID Riwayat:</label><br>
        <input type="number" id="id_riwayat" name="id_riwayat" required><br><br>

        <label for="id_user">ID User:</label><br>
        <input type="number" id="id_user" name="id_user" required><br><br>

        <input type="submit" value="Tambah Penghuni">
    </form>
</body>
</html>
